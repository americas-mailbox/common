<?php
declare(strict_types=1);

namespace AMB\View\ShippingEvent\Handler;

use AMB\Entity\Shipping\ShippingEvent;
use AMB\Interactor\RapidCityTime;

final class HandleIntermittent implements RecurrenceHandlerInterface
{
    public function __construct(
        private SetDateInEventData $setDateInEvent,
    ) { }

    public function handle(ShippingEvent $shippingEvent, RapidCityTime $startDate, RapidCityTime $endDate): array
    {
        $eventEndDate = $shippingEvent->getEndDate();
        $weeksBetween = $shippingEvent->getWeeksBetween();
        $eventDate = $shippingEvent->getNextWeekly();

        $weeklyEvent = (new NormalizeShippingEvent)->normalize($shippingEvent);
        $weeklyEvent['recurrence'] = 'intermittent';
        $weeklyEvent['weeksBetween'] = $weeksBetween;

        $events = [];
        while ($eventDate->lt($startDate)) {
            $eventDate = $this->getDateForIntermittentWeeks($eventDate, $weeksBetween);
        }
        while ($eventDate->lte($endDate) && $eventDate->lte($eventEndDate)) {
            $dateString = $this->setDateInEvent->set($shippingEvent, $weeklyEvent, $eventDate);
            $events[$dateString] = $weeklyEvent;
            $eventDate = $this->getDateForIntermittentWeeks($eventDate, $weeksBetween);
        }

        return $events;
    }

    private function getDateForIntermittentWeeks(RapidCityTime $date, int $weeksBetween): RapidCityTime
    {
        return $date->clone()->addWeeks($weeksBetween);
    }
}
