<?php
declare(strict_types=1);

namespace AMB\Interactor\ShippingEvent;

use AMB\Entity\Shipping\ShippingEvent;

final class DeleteAllEvents
{
    public function __construct(
        private SaveShippingEvent $saveShippingEvent,
    ) {
    }

    public function delete(ShippingEvent $shippingEvent)
    {
        $shippingEvent
            ->setActive(false);
        $this->saveShippingEvent->save($shippingEvent);

        return ['id' => $shippingEvent->getId()];
    }
}
