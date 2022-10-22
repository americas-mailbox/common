<?php
declare(strict_types=1);

namespace AMB\Interactor\ShippingEvent;

use AMB\Entity\Shipping\ShippingEvent;
use AMB\Factory\ShippingEvent\OneTimeShippingEventFactory;
use AMB\Interactor\RapidCityTime;
use AMB\Interactor\Shipping\GetNextDate;
use AMB\Interactor\Shipping\GetPreviousDate;
use AMB\Interactor\Shipping\SaveShippingEvent;

final class UpdateOnlyThisEvent
{
    public function __construct(
        private CloneEvent $cloneEvent,
        private GetNextDate $getNextDate,
        private GetPreviousDate $getPreviousDate,
        private SaveShippingEvent $saveShippingEvent,
        private UpdateEvent $updateEvent,
    ) {
    }

    public function update(ShippingEvent $shippingEvent, array $data): array
    {
        $eventDate = new RapidCityTime($data['date']);
        $nextDate = $this->getNextDate->get($shippingEvent, $eventDate);
        $previousDate = $this->getPreviousDate->get($shippingEvent, $eventDate);

        if ($eventDate->eq($shippingEvent->getStartDate())) {
            return $this->handleUpdateOnStartDate($shippingEvent, $nextDate, $data);
        }
        if ($eventDate->eq($shippingEvent->getEndDate())) {
            return $this->handleUpdateOnEndDate($shippingEvent, $previousDate, $data);
        }

        $clonedEvent = $this->cloneEvent->clone($shippingEvent);
        $clonedEvent->setStartDate($nextDate);
        $this->saveShippingEvent->save($clonedEvent);

        $shippingEvent->setEndDate($previousDate);
        $this->saveShippingEvent->save($shippingEvent);

        return $this->createOneTimeEvent($shippingEvent, $data);
    }

    private function handleUpdateOnStartDate(
        ShippingEvent $shippingEvent,
        RapidCityTime $nextDate,
        array $data,
    ): array {
        $shippingEvent->setStartDate($nextDate);
        $this->saveShippingEvent->save($shippingEvent);

        return $this->createOneTimeEvent($shippingEvent, $data);
    }

    private function handleUpdateOnEndDate(
        ShippingEvent $shippingEvent,
        RapidCityTime $previousDate,
        array $data,
    ): array {
        $shippingEvent->setEndDate($previousDate);
        $this->saveShippingEvent->save($shippingEvent);

        return $this->createOneTimeEvent($shippingEvent, $data);
    }

    private function createOneTimeEvent(ShippingEvent $shippingEvent, array $data): array
    {
        $singleEvent = (new OneTimeShippingEventFactory)($data);
        $singleEvent->setMember($shippingEvent->getMember());

        return $this->updateEvent->update($singleEvent, $data);
    }
}
