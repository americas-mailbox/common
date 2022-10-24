<?php
declare(strict_types=1);

namespace AMB\Interactor\ShippingEvent;

use AMB\Entity\Shipping\ShippingEvent;
use AMB\Interactor\Db\HydrateShippingEvent;
use AMB\Interactor\Shipping\GatherShippingEventDataById;

final class FindShippingEventById
{
    /** @var \AMB\Interactor\Shipping\GatherShippingEventDataById */
    private $gatherShippingEventData;
    /** @var \AMB\Interactor\Db\HydrateShippingEvent */
    private $hydrateShippingEvent;

    public function __construct(
        GatherShippingEventDataById $gatherShippingEventData,
        HydrateShippingEvent $hydrateShippingEvent
    ) {
        $this->gatherShippingEventData = $gatherShippingEventData;
        $this->hydrateShippingEvent = $hydrateShippingEvent;
    }

    public function find($shippingEventId): ?ShippingEvent
    {
        $shippingEventData = $this->gatherShippingEventData->gather($shippingEventId);
        if (empty($shippingEventData)) {
            return null;
        }

        return $this->hydrateShippingEvent->hydrate($shippingEventData);
    }
}
