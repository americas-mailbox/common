<?php
declare(strict_types=1);

namespace AMB\View\ShippingEvent\Handler;

use AMB\Entity\Shipping\ShippingEvent;
use AMB\Interactor\RapidCityTime;

final class HandleFirstWeekdayOfMonth implements RecurrenceHandlerInterface
{
    public function __construct(
        private SetDateInEventData $setDateInEvent,
    ) { }

    public function handle(ShippingEvent $shippingEvent, RapidCityTime $startDate, RapidCityTime $endDate): array
    {
        $eventEndDate = $shippingEvent->getEndDate();
        $weekDayOfTheMonth = $shippingEvent->getFirstWeekdayOfTheMonth()->getValue();

        $monthEvent = (new NormalizeShippingEvent)->normalize($shippingEvent);
        $monthEvent['recurrence'] = 'firstOfMonth';
        $monthEvent['firstWeekdayOfTheMonth'] = $weekDayOfTheMonth;

        if ($shippingEvent->getStartDate()->gte($startDate)) {
            $eventDate = $shippingEvent->getStartDate();
        } else {
            $eventDate = $this->getFirstWeekdayForMonth($startDate, $weekDayOfTheMonth);
            if ($eventDate->lte($startDate)) {
                $eventDate = $this->getFirstWeekdayForNextMonth($startDate, $weekDayOfTheMonth);
            }
        }
        $events = [];
        while ($eventDate->lte($endDate) && $eventDate->lte($eventEndDate)) {
            $dateString = $this->setDateInEvent->set($shippingEvent, $monthEvent, $eventDate);
            $events[$dateString] = $monthEvent;
            $eventDate = $this->getFirstWeekdayForNextMonth($eventDate, $weekDayOfTheMonth);
        }

        return $events;
    }

    private function getFirstWeekdayForMonth(RapidCityTime $date, int $dayOfTheWeek): RapidCityTime
    {
        $dateDescription = 'first ' . (new DayOfTheWeekName)($dayOfTheWeek) . ' of ' . $date->format('F Y');

        return new RapidCityTime($dateDescription);
    }

    private function getFirstWeekdayForNextMonth(RapidCityTime $date, int $dayOfTheWeek): RapidCityTime
    {
        $nextMonth = $date->clone()->startOfMonth()->addMonth();

        return $this->getFirstWeekdayForMonth($nextMonth, $dayOfTheWeek);
    }
}
