<?php
declare(strict_types=1);

namespace AMB\View\ShippingEvent\Handler;

use AMB\Entity\Shipping\ShippingEvent;
use AMB\Interactor\OfficeClosure\IsOfficeClosed;
use AMB\Interactor\RapidCityTime;

final class HandleDaily implements RecurrenceHandlerInterface
{
    public function __construct(
        private SetDateInEventData $setDateInEvent,
        private IsOfficeClosed $isOfficeClosed,
    ) { }

    public function handle(ShippingEvent $shippingEvent, RapidCityTime $startDate, RapidCityTime $endDate): array
    {
        $eventEndDate = $shippingEvent->getEndDate();

        $weeklyEvent = (new NormalizeShippingEvent)->normalize($shippingEvent);
        $weeklyEvent['recurrence'] = 'daily';
        if ($shippingEvent->getStartDate()->lte($startDate)) {
            $eventDate = $startDate->clone();
        } else {
            $eventDate = $shippingEvent->getStartDate()->clone();
        }

        $events = [];
        while ($eventDate->lte($endDate) && $eventDate->lte($eventEndDate)) {
            $dateString = $this->setDateInEvent->set($shippingEvent, $weeklyEvent, $eventDate);
            $events[$dateString] = $weeklyEvent;
            $eventDate->addDay();
            $eventDate = $this->nextBusinessDate($eventDate);
        }

        return $events;
    }

    private function nextBusinessDate(RapidCityTime $date): RapidCityTime
    {
        $nextDate = $date->clone();
        while ($this->isOfficeClosed->on($nextDate)) {
            $nextDate->addDay();
        }

        return $nextDate;
    }
}
