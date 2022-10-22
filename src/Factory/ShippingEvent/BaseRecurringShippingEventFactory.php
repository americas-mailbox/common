<?php
declare(strict_types=1);

namespace AMB\Factory\ShippingEvent;

use AMB\Entity\Shipping\ShippingEvent;
use AMB\Interactor\RapidCityTime;

abstract class BaseRecurringShippingEventFactory
{
    protected function createRecurringEvent($data): ShippingEvent
    {
        if ('infinite' === $data['recurrenceEnding']) {
            $endDate = new RapidCityTime('2100-1-1');
        } else {
            $endDate = new RapidCityTime($data['endDate']);
        }
        $shippingEvent = (new ShippingEvent())
            ->setActive(true)
            ->setDayOfTheMonth(null)
            ->setDayOfTheWeek(null)
            ->setNextWeekly(null)
            ->setWeeksBetween(null)
            ->setStartDate(new RapidCityTime($data['startDate']))
            ->setEndDate($endDate);

        return $shippingEvent;
    }
}
