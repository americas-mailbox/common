<?php
declare(strict_types=1);

namespace AMB\Interactor\View\ShippingEvent\Handler;

use AMB\Entity\Shipping\ShippingEvent;
use AMB\Interactor\RapidCityTime;

final class HandleLastWeekdayOfMonth implements RecurrenceHandlerInterface
{
    public function __construct(
        private SetDateInEventData $setDateInEvent,
    ) { }

    public function handle(ShippingEvent $shippingEvent, RapidCityTime $startDate, RapidCityTime $endDate): array
    {
        $eventEndDate = $shippingEvent->getEndDate();
        $weekDayOfTheMonth = $shippingEvent->getLastWeekdayOfTheMonth()->getValue();

        $monthEvent = (new NormalizeShippingEvent)->normalize($shippingEvent);
        $monthEvent['recurrence'] = 'lastOfMonth';
        $monthEvent['lastWeekdayOfTheMonth'] = $weekDayOfTheMonth;

        if ($shippingEvent->getStartDate()->gte($startDate)) {
            $eventDate = $shippingEvent->getStartDate();
        } else {
            $eventDate = $this->getLastWeekdayForMonth($startDate, $weekDayOfTheMonth);
            if ($eventDate->lte($startDate)) {
                $eventDate = $this->getLastWeekdayForNextMonth($startDate, $weekDayOfTheMonth);
            }
        }
        $events = [];
        while ($eventDate->lte($endDate) && $eventDate->lte($eventEndDate)) {
            $dateString = $this->setDateInEvent->set($shippingEvent, $monthEvent, $eventDate);
            $events[$dateString] = $monthEvent;
            $eventDate = $this->getLastWeekdayForNextMonth($eventDate, $weekDayOfTheMonth);
        }

        return $events;
    }

    private function getLastWeekdayForMonth(RapidCityTime $date, int $dayOfTheWeek): RapidCityTime
    {
        $dateDescription = 'last ' . (new DayOfTheWeekName)($dayOfTheWeek) . ' of ' . $date->format('F Y');

        return new RapidCityTime($dateDescription);
    }

    private function getLastWeekdayForNextMonth(RapidCityTime $date, int $dayOfTheWeek): RapidCityTime
    {
        return $this->getLastWeekdayForMonth($date->clone()->addMonthNoOverflow(), $dayOfTheWeek);
    }
}
