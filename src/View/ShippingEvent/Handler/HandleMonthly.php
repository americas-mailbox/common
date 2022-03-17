<?php
declare(strict_types=1);

namespace AMB\View\ShippingEvent\Handler;

use AMB\Entity\Shipping\ShippingEvent;
use AMB\Interactor\RapidCityTime;

final class HandleMonthly implements RecurrenceHandlerInterface
{
    public function __construct(
        private SetDateInEventData $setDateInEvent,
    ) { }

    public function handle(ShippingEvent $shippingEvent, RapidCityTime $startDate, RapidCityTime $endDate): array
    {
        $eventEndDate = $shippingEvent->getEndDate();
        $dayOfTheMonth = $shippingEvent->getDayOfTheMonth();

        $monthEvent = (new NormalizeShippingEvent)->normalize($shippingEvent);
        $monthEvent['recurrence'] = 'monthly';
        $monthEvent['dayOfTheMonth'] = $dayOfTheMonth;

        if ($shippingEvent->getStartDate()->gte($startDate)) {
            $eventDate = $this->getDateForMonth($shippingEvent->getStartDate(), $dayOfTheMonth);
        } else {
            $eventDate = $this->getDateForMonth($startDate, $dayOfTheMonth);
            if ($eventDate->lt($startDate)) {
                $eventDate = $this->getDateForNextMonth($startDate, $dayOfTheMonth);
            }
        }
        $events = [];
        while ($eventDate->lte($endDate) && $eventDate->lte($eventEndDate)) {
            $dateString = $this->setDateInEvent->set($shippingEvent, $monthEvent, $eventDate);
            $events[$dateString] = $monthEvent;
            $eventDate = $this->getDateForNextMonth($eventDate, $dayOfTheMonth);
        }

        return $events;
    }

    private function getDateForMonth(RapidCityTime $date, int $dayOfTheMonth): RapidCityTime
    {
        $dateDescription = $date->format('F ') . $dayOfTheMonth . $date->format(', Y');

        return new RapidCityTime($dateDescription);
    }

    private function getDateForNextMonth(RapidCityTime $date, int $dayOfTheMonth): RapidCityTime
    {
        return $date->clone()->startOfMonth()->addMonth()->setDay($dayOfTheMonth);
    }
}
