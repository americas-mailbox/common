<?php
declare(strict_types=1);

namespace AMB\Factory\ShippingEvent;

use AMB\Entity\Shipping\DayOfTheWeek;
use AMB\Entity\Shipping\RecurrenceType;
use AMB\Entity\Shipping\ShippingEvent;

final class FirstOfMonthRecurrenceShippingEventFactory extends BaseRecurringShippingEventFactory
{
    public function __invoke(array $data): ShippingEvent
    {
        return $this->createRecurringEvent($data)
            ->setFirstWeekdayOfTheMonth(new DayOfTheWeek($data['dayOfTheWeek']))
            ->setRecurrenceType(RecurrenceType::FIRST_WEEKDAY_OF_MONTH());
    }
}
