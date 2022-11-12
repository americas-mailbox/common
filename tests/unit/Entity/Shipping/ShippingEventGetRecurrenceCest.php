<?php
declare(strict_types=1);

namespace Entity\Shipping;

use AMB\Entity\Shipping\DayOfTheWeek;
use AMB\Entity\Shipping\RecurrenceType;
use AMB\Entity\Shipping\ShippingEvent;
use AMB\Interactor\RapidCityTime;
use UnitTester;

class ShippingEventGetRecurrenceCest
{
    public function testNonRecurring(UnitTester $I)
    {
        $event = (new ShippingEvent());

        $I->assertTrue($event->getRecurrenceType()->equals(RecurrenceType::DOES_NOT_REPEAT()));
    }

    public function testDaily(UnitTester $I)
    {
        $event = $this->buildDailyEvent();

        $I->assertTrue($event->getRecurrenceType()->equals(RecurrenceType::DAILY()));
    }

    public function testIntermittent(UnitTester $I)
    {
        $event = $this->buildIntermittentEvent();

        $I->assertTrue($event->getRecurrenceType()->equals(RecurrenceType::INTERMITTENT()));
    }

    public function testFirstDayOfMonth(UnitTester $I)
    {
        $event = $this->buildFirstDayOfMonthEvent();

        $I->assertTrue($event->getRecurrenceType()->equals(RecurrenceType::FIRST_WEEKDAY_OF_MONTH()));
    }

    public function testLastDayOfMonth(UnitTester $I)
    {
        $event = $this->buildLastDayOfMonthEvent();

        $I->assertTrue($event->getRecurrenceType()->equals(RecurrenceType::LAST_WEEKDAY_OF_MONTH()));
    }

    public function testMonthly(UnitTester $I)
    {
        $event = $this->buildMonthlyEvent();

        $I->assertTrue($event->getRecurrenceType()->equals(RecurrenceType::MONTHLY()));
    }

    public function testWeekly(UnitTester $I)
    {
        $event = $this->buildWeeklyEvent();

        $I->assertTrue($event->getRecurrenceType()->equals(RecurrenceType::WEEKLY()));
    }

    private function buildDailyEvent(): ShippingEvent
    {
        return (new ShippingEvent)
            ->setDaily(true);
    }

    private function buildIntermittentEvent(): ShippingEvent
    {
        return (new ShippingEvent)
            ->setNextWeekly(new RapidCityTime('2019-02-27'))
            ->setWeeksBetween(3);
    }

    private function buildFirstDayOfMonthEvent(): ShippingEvent
    {
        return (new ShippingEvent)
            ->setFirstWeekdayOfTheMonth(DayOfTheWeek::MONDAY());
    }

    private function buildLastDayOfMonthEvent(): ShippingEvent
    {
        return (new ShippingEvent)
            ->setLastWeekdayOfTheMonth(DayOfTheWeek::MONDAY());
    }

    private function buildMonthlyEvent(): ShippingEvent
    {
        return (new ShippingEvent)
            ->setDayOfTheMonth(25);
    }

    private function buildWeeklyEvent(): ShippingEvent
    {
        return (new ShippingEvent)
            ->setDayOfTheWeek(DayOfTheWeek::WEDNESDAY())
            ->setWeeksBetween(1);
    }
}
