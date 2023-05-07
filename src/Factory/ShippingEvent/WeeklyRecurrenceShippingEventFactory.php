<?php
declare(strict_types=1);

namespace AMB\Factory\ShippingEvent;

use AMB\Entity\Shipping\DayOfTheWeek;
use AMB\Entity\Shipping\RecurrenceType;
use AMB\Entity\Shipping\ShippingEvent;
use AMB\Interactor\RapidCityTime;

final class WeeklyRecurrenceShippingEventFactory extends BaseRecurringShippingEventFactory
{
    public function __invoke(array $data): ShippingEvent
    {
        if (!isset($data['dayOfTheWeek'])) {
            $date = new RapidCityTime($data['startDate']);
            $data['dayOfTheWeek'] = $date->dayOfWeek;
        }

        return $this->createRecurringEvent($data)
            ->setDayOfTheWeek(new DayOfTheWeek($data['dayOfTheWeek']))
            ->setRecurrenceType(RecurrenceType::WEEKLY())
            ->setWeeksBetween(1);
    }
}
