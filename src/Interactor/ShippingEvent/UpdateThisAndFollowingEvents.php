<?php
declare(strict_types=1);

namespace AMB\Interactor\ShippingEvent;

use AMB\Entity\Shipping\ShippingEvent;
use AMB\Interactor\RapidCityTime;
use AMB\Interactor\Shipping\SaveShippingEvent;

final class UpdateThisAndFollowingEvents
{
    public function __construct(
        private CloneEvent $cloneEvent,
        private DeleteThisAndFollowingEvent $deleteThisAndFollowingEvent,
        private SaveShippingEvent $saveShippingEvent,
        private UpdateEvent $updateEvent,
    ) {}

    public function update(ShippingEvent $shippingEvent, array $data): array
    {
        $splitDate = new RapidCityTime($data['date']);
        if ($splitDate->eq($shippingEvent->getStartDate())) {
            return $this->updateOrDelete($shippingEvent, $data, $splitDate);
        }
        $clone = $this->cloneEvent->split($shippingEvent, $splitDate);
        $this->saveShippingEvent->save($shippingEvent);

        return $this->updateOrDelete($clone, $data, $splitDate);
    }

    private function updateOrDelete(ShippingEvent $shippingEvent, array $data, RapidCityTime $date): array
    {
        if ((new ShouldDeleteEvent)($data)) {
            return $this->deleteThisAndFollowingEvent->delete($shippingEvent, $date);
        }

        return $this->updateEvent->update($shippingEvent, $data);
    }
}
