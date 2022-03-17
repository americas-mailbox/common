<?php
declare(strict_types=1);

namespace AMB\Interactor\ShippingEvent;

use AMB\Interactor\RapidCityTime;
use AMB\View\ShippingEvent\GatherFutureEvents;
use AMB\View\ShippingEvent\GatherPastShipments;

final class MemberShippingEventsForCalendar
{
    public function __construct(
        private GatherFutureEvents $gatherFutureEvents,
        private GatherPastShipments $gatherPastShipments,
    ) { }

    public function gather(int $memberId, RapidCityTime $startDate, RapidCityTime $endDate = null): array
    {
        if (null === $endDate) {
            $endDate = $startDate->clone()->endOfMonth();
        }
        $shipments = $this->gatherPastShipments->gather($memberId, $startDate, $endDate);
        $events = $this->gatherFutureEvents->gather($memberId, $startDate, $endDate);

        return array_merge($events, $shipments);
    }
}
