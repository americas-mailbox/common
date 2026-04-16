<?php
declare(strict_types=1);

namespace AMB\Interactor\Shipping;

use AMB\Entity\Shipping\ShippingEvent;
use AMB\Interactor\OfficeClosure\IsOfficeClosedInterface;
use AMB\Interactor\RapidCityTime;

final class GetNextDate
{
    public function __construct(
        private IsOfficeClosedInterface $isOfficeClosed,
    ) {}

    public function __invoke(ShippingEvent $event, RapidCityTime $startingDate, bool $avoidClosures = false): RapidCityTime
    {
        $getNextDate = $this->camelize($event->getRecurrenceType()->getValue());

        $nextDate = $startingDate->clone();

        $this->$getNextDate($event, $nextDate, $avoidClosures);

        if (!$avoidClosures) {
            return $nextDate;
        }
        while ($this->isOfficeClosed->on($nextDate)) {
            $this->$getNextDate($event, $nextDate, $avoidClosures);
        }

        return $nextDate;
    }

    private function camelize(string $value): string
    {
        $normalized = str_replace(' ', '', ucwords(str_replace('_', ' ', $value)));

        return lcfirst($normalized);
    }

    public function get(ShippingEvent $event, RapidCityTime $startingDate, bool $avoidClosures = false): RapidCityTime
    {
        return $this->__invoke($event, $startingDate, $avoidClosures);
    }

    public function daily(ShippingEvent $event, RapidCityTime $date, bool $avoidClosures)
    {
        $date->addDay();
    }

    public function firstWeekdayOfMonth(ShippingEvent $event, RapidCityTime $date, bool $avoidClosures)
    {
        $dayOfTheWeek = $event->getFirstWeekdayOfTheMonth()->getKey();
        $dateString = "first $dayOfTheWeek of next month";

        $date->modify($dateString);
    }

    public function intermittent(ShippingEvent $event, RapidCityTime $date, bool $avoidClosures)
    {
        $date->addWeeks($event->getWeeksBetween());
    }

    public function lastWeekdayOfMonth(ShippingEvent $event, RapidCityTime $date, bool $avoidClosures)
    {
        $dayOfTheWeek = $event->getLastWeekdayOfTheMonth()->getKey();
        $dateString = "last $dayOfTheWeek of next month";

        $date->modify($dateString);
    }

    public function monthly(ShippingEvent $event, RapidCityTime $date, bool $avoidClosures)
    {
        $date->addMonth();
    }

    public function weekly(ShippingEvent $event, RapidCityTime $date, bool $avoidClosures)
    {
        $date->addWeek();
    }
}
