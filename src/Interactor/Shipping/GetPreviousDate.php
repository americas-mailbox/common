<?php
declare(strict_types=1);

namespace AMB\Interactor\Shipping;

use AMB\Entity\Shipping\ShippingEvent;
use AMB\Interactor\OfficeClosure\IsOfficeClosedInterface;
use AMB\Interactor\RapidCityTime;

final class GetPreviousDate
{
    public function __construct(
        private IsOfficeClosedInterface $isOfficeClosed,
    ) {}

    public function __invoke(ShippingEvent $event, RapidCityTime $startingDate, bool $avoidClosures = false): RapidCityTime
    {
        $getPreviousDate = $this->camelize($event->getRecurrenceType()->getValue());
        $previousDate = $startingDate->clone();

        $this->$getPreviousDate($event, $previousDate, $avoidClosures);

        if (!$avoidClosures) {
            return $previousDate;
        }
        while ($this->isOfficeClosed->on($previousDate)) {
            $this->$getPreviousDate($event, $previousDate, $avoidClosures);
        }

        return $previousDate;
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

    public function daily(ShippingEvent $event, RapidCityTime $startingDate, bool $avoidClosures)
    {
        $startingDate->subDay();
    }

    public function firstWeekdayOfMonth(ShippingEvent $event, RapidCityTime $startingDate, bool $avoidClosures)
    {
        $dayOfTheWeek = $event->getFirstWeekdayOfTheMonth()->getKey();
        $dateString = "first $dayOfTheWeek of last month";

        $startingDate->modify($dateString);
    }

    public function intermittent(ShippingEvent $event, RapidCityTime $startingDate, bool $avoidClosures)
    {
        $startingDate->subWeeks($event->getWeeksBetween());
    }

    public function lastWeekdayOfMonth(ShippingEvent $event, RapidCityTime $startingDate, bool $avoidClosures)
    {
        $dayOfTheWeek = $event->getLastWeekdayOfTheMonth()->getKey();
        $dateString = "last $dayOfTheWeek of last month";

        $startingDate->modify($dateString);
    }

    public function monthly(ShippingEvent $event, RapidCityTime $startingDate, bool $avoidClosures)
    {
        $startingDate->subMonth();
    }

    public function weekly(ShippingEvent $event, RapidCityTime $startingDate, bool $avoidClosures)
    {
        $startingDate->subWeek();
    }
}
