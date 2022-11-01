<?php
declare(strict_types=1);

namespace AMB\Interactor\ShippingEvent;

use AMB\Entity\Shipping\ShippingEvent;
use AMB\Interactor\Db\HydrateShippingEvent;

final class FindShippingEventById
{
    public function __construct(
        private GatherShippingEventDataById $gatherShippingEventData,
        private HydrateShippingEvent $hydrateShippingEvent
    ) {}

    public function find($shippingEventId): ?ShippingEvent
    {
        $shippingEventData = $this->gatherShippingEventData->gather($shippingEventId);
        if (empty($shippingEventData)) {
            return null;
        }

        return $this->hydrateShippingEvent->hydrate($shippingEventData);
    }
}
