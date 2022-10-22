<?php
declare(strict_types=1);

namespace AMB\Factory\ShippingEvent;

use AMB\Entity\Shipping\DayOfTheWeek;
use AMB\Entity\Shipping\RecurrenceType;
use AMB\Entity\Shipping\ShippingEvent;

final class WeeklyRecurrenceShippingEventFactory extends BaseRecurringShippingEventFactory
{
    public function __invoke(array $data): ShippingEvent
    {
        return $this->createRecurringEvent($data)
            ->setDayOfTheWeek(new DayOfTheWeek($data['dayOfTheWeek']))
            ->setRecurrenceType(RecurrenceType::WEEKLY())
            ->setWeeksBetween(1);
    }
}
