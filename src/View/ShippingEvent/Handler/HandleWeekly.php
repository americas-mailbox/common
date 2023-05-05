<?php
declare(strict_types=1);

namespace AMB\View\ShippingEvent\Handler;

use AMB\Entity\Shipping\DayOfTheWeek;
use AMB\Entity\Shipping\ShippingEvent;
use AMB\Interactor\RapidCityTime;

final class HandleWeekly implements RecurrenceHandlerInterface
{
    public function __construct(
        private NormalizeShippingEvent $normalizeShippingEvent,
        private SetDateInEventData $setDateInEvent,
    ) { }

    public function handle(ShippingEvent $shippingEvent, RapidCityTime $startDate, RapidCityTime $endDate): array
    {
        $eventEndDate = $shippingEvent->getEndDate();

        $weeklyEvent = $this->normalizeShippingEvent->normalize($shippingEvent);
        $weeklyEvent['recurrence'] = 'weekly';

        $eventDate = $this->determineStartingWeeklyEventDate($shippingEvent, $startDate);

        $events = [];
        while ($eventDate->lte($endDate) && $eventDate->lte($eventEndDate)) {
            $dateString = $this->setDateInEvent->set($shippingEvent, $weeklyEvent, $eventDate);
            $events[$dateString] = $weeklyEvent;
            $eventDate->addWeek();
        }

        return $events;
    }

    private function determineStartingWeeklyEventDate(ShippingEvent $shippingEvent, RapidCityTime $beginningDate): RapidCityTime
    {
        if ($shippingEvent->getStartDate()->gte($beginningDate)) {
            return $shippingEvent->getStartDate()->clone();
        }
        if ($beginningDate->dayOfWeek === $shippingEvent->getDayOfTheWeek()->getValue()) {
            return $beginningDate->clone();
        }

        return $this->nextDayOfTheWeek($beginningDate, $shippingEvent->getDayOfTheWeek());
    }

    private function nextDayOfTheWeek(RapidCityTime $date, DayOfTheWeek $dayOfTheWeek): RapidCityTime
    {
        return $date->clone()->modify('next ' . (new DayOfTheWeekName)($dayOfTheWeek));
    }
}
