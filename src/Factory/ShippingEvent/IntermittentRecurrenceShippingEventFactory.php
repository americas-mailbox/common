<?php
declare(strict_types=1);

namespace AMB\Factory\ShippingEvent;

use AMB\Entity\Shipping\DayOfTheWeek;
use AMB\Entity\Shipping\RecurrenceType;
use AMB\Entity\Shipping\ShippingEvent;
use AMB\Interactor\RapidCityTime;

final class IntermittentRecurrenceShippingEventFactory extends BaseRecurringShippingEventFactory
{
    public function __invoke(array $data): ShippingEvent
    {
        $shippingEvent = $this->createRecurringEvent($data);
        if (!isset($data['dayOfTheWeek'])) {
            $date = new RapidCityTime($data['startDate']);
            $data['dayOfTheWeek'] = $date->dayOfWeek;
        }

        $dayOfTheWeek = (new DayOfTheWeek((int) $data['dayOfTheWeek']));
        $startDate = $shippingEvent->getStartDate()->copy();
        $weeksBetween = (int) $data['weeksBetween'];

        $shippingEvent
            ->setDayOfTheWeek($dayOfTheWeek)
            ->setNextWeekly($startDate)
            ->setRecurrenceType(RecurrenceType::INTERMITTENT())
            ->setWeeksBetween($weeksBetween);

        return $shippingEvent;
    }
}
