<?php
declare(strict_types=1);

namespace AMB\Factory\ShippingEvent;

use AMB\Entity\Shipping\RecurrenceType;
use AMB\Entity\Shipping\ShippingEvent;
use AMB\Interactor\RapidCityTime;

final class OneTimeShippingEventFactory
{
    public function __invoke(array $data): ShippingEvent
    {
        $date = new RapidCityTime($data['date']);

        return (new ShippingEvent())
            ->setActive(true)
            ->setDayOfTheMonth(null)
            ->setDayOfTheWeek(null)
            ->setFirstWeekdayOfTheMonth(null)
            ->setLastWeekdayOfTheMonth(null)
            ->setNextWeekly(null)
            ->setRecurrenceType(RecurrenceType::DOES_NOT_REPEAT())
            ->setWeeksBetween(null)
            ->setEndDate($date)
            ->setStartDate($date);
    }
}
