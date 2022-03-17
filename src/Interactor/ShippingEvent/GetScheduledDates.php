<?php
declare(strict_types=1);

namespace AMB\Interactor\ShippingEvent;

use AMB\Entity\Shipping\DayOfTheWeek;
use AMB\Entity\Shipping\ShippingEvent;
use AMB\Interactor\Db\HydrateShippingEvent;
use AMB\Interactor\RapidCityTime;
use IamPersistent\SimpleShop\Interactor\PascalCase;

final class GetScheduledDates
{
    /** @var string[] */
    private $collectedDates;
    /** @var \AMB\Interactor\RapidCityTime */
    private $endDate;
    /** @var \AMB\Interactor\RapidCityTime */
    private $startDate;

    public function __construct(
        private GatherScheduledShipmentsData $gatherShipmentSchedulesData,
        private HydrateShippingEvent $hydrateShippingEvent,
    ) {}

    /**
     * @param $memberId
     * @param \AMB\Interactor\RapidCityTime $startDate
     * @param \AMB\Interactor\RapidCityTime $endDate
     *
     * @return \AMB\Entity\Shipping\ShippingEvent[]
     * @throws \Exception
     */
    public function getCalendarEvents($memberId, RapidCityTime $startDate, RapidCityTime $endDate): array
    {
        $this->startDate = $startDate->clone();
        $this->endDate = $endDate->clone();
        if (!$data = $this->gatherShipmentSchedulesData->gather($memberId, $startDate, $endDate)) {
            return [];
        }
        $events = $this->processData($data);

        return $events;
    }

    public function getDisabledDatesForCalendar($memberId, RapidCityTime $date = null, $totalMonths = 24): string
    {
        if (empty($date)) {
            $date = RapidCityTime::today();
        }
        $this->startDate = $date->clone();
        $this->endDate = $date->addMonths($totalMonths);
        if (!$data = $this->gatherShipmentSchedulesData->gather($memberId, $date, $totalMonths)) {
            return '';
        }

        $this->processData($data);

        return $this->getCollectedDates();
    }

    private function addToDates(RapidCityTime $date)
    {
        $key = $date->format('Ymd');
        $this->collectedDates[$key] = $this->getDateString($date);
    }

    private function getCollectedDates()
    {
        ksort($this->collectedDates);

        return implode(" ,\n", $this->collectedDates);
    }

    private function getDateString(RapidCityTime $date): string
    {
        return '"' . $date->format('m/d/Y') . '"';
    }

    private function getDayForMonth(RapidCityTime $date, int $day): RapidCityTime
    {
        $trialDate = $date->clone()->day($day);
        if ($date->month !== $trialDate->month) {
            return $date->endOfMonth();
        }

        return $date->day($day);
    }

    private function isInDateRange(RapidCityTime $date): bool
    {
        if ($date->isBefore($this->startDate)) {
            return false;
        }

        return $date->isBefore($this->endDate);
    }

    private function processData(array $data)
    {
        $events = [];
        foreach ($data as $datum) {
            $event = ($this->hydrateShippingEvent)($datum);
//            if ($this->processEvent($event)) {
//                $events[] = $event;
//            }
            $events[] = $event;
        }

        return $events;
    }

    private function processEvent(ShippingEvent $event): bool
    {
        if (!$event->isRecurring()) {
            return $this->processSingleDay($event);
        }
        $recurrenceType = $event->getRecurrenceType();
        $method = 'process'.(new PascalCase)($recurrenceType->getValue());

        return $this->$method($event);
    }

    private function processIntermittent(ShippingEvent $event)
    {
        $weeksBetween = $event->getWeeksBetween();
        $endDate = $event->getEndDate();
        $currentDate = $event->getNextWeekly();

        while ($currentDate->isBefore($this->startDate)) {
            $currentDate->addWeeks($weeksBetween);
        }
        while ($currentDate->lte($endDate) && $currentDate->lte($this->endDate)) {
            $this->addToDates($currentDate);
            $currentDate->addWeeks($weeksBetween);
        }
    }

    private function processFirstWeekdayOfMonth(ShippingEvent $event)
    {
        $dayOfTheWeek = $event->getFirstWeekdayOfTheMonth()->getValue();
        $endDate = $event->getEndDate();
        $currentDate = $this->startDate->clone();
        if (!$this->sameWeekDay($dayOfTheWeek, $currentDate)) {
            $currentDate->firstOfMonth($dayOfTheWeek);
            if ($currentDate->isBefore($this->startDate)) {
                $currentDate->addMonth()->firstOfMonth($dayOfTheWeek);
            }
        }
        while ($currentDate->isBefore($endDate) && $currentDate->isBefore($this->endDate)) {
            $this->addToDates($currentDate);
            $currentDate->addMonth()->firstOfMonth($dayOfTheWeek);
        }
    }

    private function processLastWeekdayOfMonth(ShippingEvent $event)
    {
        $dayOfTheWeek = $event->getLastWeekdayOfTheMonth()->getValue();
        $endDate = $event->getEndDate();
        $currentDate = $this->startDate->clone()->lastOfMonth($dayOfTheWeek);
        if ($currentDate->isBefore($this->startDate)) {
            $currentDate->addMonth()->lastOfMonth($dayOfTheWeek);
        }
        while ($currentDate->isBefore($endDate) && $currentDate->isBefore($this->endDate)) {
            $this->addToDates($currentDate);
            $currentDate->addMonth()->lastOfMonth($dayOfTheWeek);
        }
    }

    private function processMonthly(ShippingEvent $event)
    {
        $day = $event->getDayOfTheMonth();
        $endDate = $event->getEndDate();
        $currentDate = $this->getDayForMonth($this->startDate->clone(), $day);

        // how do deal with 29,30,31?
        if ($currentDate->isBefore($this->startDate)) {
            $currentDate = $this->getDayForMonth($currentDate->addMonth(), $day);
        }
        while ($currentDate->lte($endDate) && $currentDate->lte($this->endDate)) {
            $this->addToDates($currentDate);
            $currentDate = $this->getDayForMonth($currentDate->addMonth(), $day);
        }
    }

    private function processSingleDay(ShippingEvent $event): bool
    {
        $this->addToDates($event->getStartDate());

        return true;
    }

    private function processWeekly(ShippingEvent $event)
    {
        $dayOfTheWeek = $event->getDayOfTheWeek();
        $endDate = $event->getEndDate();
        $currentDate = $this->startDate->clone();
        if (!$this->sameWeekDay($dayOfTheWeek, $currentDate)) {
            $currentDate->next($dayOfTheWeek->getValue());
        }
        while ($currentDate->isBefore($endDate) && $currentDate->isBefore($this->endDate)) {
            $this->addToDates($currentDate);
            $currentDate->addWeek();
        }
    }

    private function sameWeekDay($dayOfTheWeek, RapidCityTime $date): bool
    {
        if ($dayOfTheWeek instanceof DayOfTheWeek) {
            $dayOfTheWeek = $dayOfTheWeek->getValue();
        }

        return $dayOfTheWeek === $date->dayOfWeek;
    }
}
