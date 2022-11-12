<?php
declare(strict_types=1);

namespace Unit\Interactor\Events;

use AMB\Interactor\RapidCityTime;
use AMB\Interactor\ShippingEvent\DeleteDateInRecurringEvent;
use Helper\Mock\SaveShippingEvent;
use Helper\Setup\CreateRecurringShipment;
use UnitTester;

class DeleteDateInRecurringEventCest
{
    /** @var \Helper\Setup\CreateRecurringShipment */
    private $createShipment;
    /** @var \AMB\Interactor\ShippingEvent\DeleteDateInRecurringEvent */
    private $deleteDateInRecurringEvent;
    /** @var \Helper\Mock\SaveShippingEvent */
    private $saveShippingEvent;

    protected function _inject(SaveShippingEvent $saveShippingEvent)
    {
        $this->saveShippingEvent = $saveShippingEvent;

        $this->deleteDateInRecurringEvent = new DeleteDateInRecurringEvent($this->saveShippingEvent);
        $this->createShipment = new CreateRecurringShipment($saveShippingEvent);
    }

    /**
     * @before resetDatabase
     */
    public function testDeleteFirstDayOfEvent(UnitTester $I)
    {
        $shippingEvent = $this->createShipment->recurring(
            3,
            new RapidCityTime('2020-01-29'),
            new RapidCityTime('2020-03-25')
        );
        $this->deleteDateInRecurringEvent->delete($shippingEvent, new RapidCityTime('2020-01-29'));

        [$event1, $event2] = $this->saveShippingEvent->getSortedEvents();

        /**
         * 2020-01-29 - 2020-01-29, not active, no next weekly
         * 2020-02-19 - 2020-03-18, active, next weekly 2020-02-05
         */
        $I->assertTrue($event1->getStartDate()->eq(new RapidCityTime('2020-01-29')));
        $I->assertTrue($event1->getEndDate()->eq(new RapidCityTime('2020-01-29')));
        $I->assertNull($event1->getNextWeekly());
        $I->assertFalse($event1->isActive());

        $I->assertTrue($event2->getStartDate()->eq(new RapidCityTime('2020-02-19')));
        $I->assertTrue($event2->getEndDate()->eq(new RapidCityTime('2020-03-25')));
        $I->assertTrue($event2->getNextWeekly()->eq(new RapidCityTime('2020-02-19')));
        $I->assertTrue($event2->isActive());
    }

    /**
     * @before resetDatabase
     */
    public function testDeleteMidEvent(UnitTester $I)
    {
        $shippingEvent = $this->createShipment->recurring(
            2,
            new RapidCityTime('2020-01-15'),
            new RapidCityTime('2020-03-25'),
            new RapidCityTime('2020-02-12')
        );
        $this->deleteDateInRecurringEvent->delete($shippingEvent, new RapidCityTime('2020-02-26'));

        [$event1, $event2, $event3] = $this->saveShippingEvent->getSortedEvents();

        /**
         * 2020-01-15 - 2020-02-12, active, next weekly 2020-02-12
         * 2020-02-26 - 2020-02-26, not active, no next weekly
         * 2020-03-11 - 2020-03-25, active, next weekly 2020-03-11
         */
        $I->assertTrue($event1->getStartDate()->eq(new RapidCityTime('2020-01-15')));
        $I->assertTrue($event1->getEndDate()->eq(new RapidCityTime('2020-02-12')));
        $I->assertTrue($event1->getNextWeekly()->eq(new RapidCityTime('2020-02-12')));
        $I->assertTrue($event1->isActive());

        $I->assertTrue($event2->getStartDate()->eq(new RapidCityTime('2020-02-26')));
        $I->assertTrue($event2->getEndDate()->eq(new RapidCityTime('2020-02-26')));
        $I->assertNull($event2->getNextWeekly());
        $I->assertFalse($event2->isActive());

        $I->assertTrue($event3->getStartDate()->eq(new RapidCityTime('2020-03-11')));
        $I->assertTrue($event3->getEndDate()->eq(new RapidCityTime('2020-03-25')));
        $I->assertTrue($event3->getNextWeekly()->eq(new RapidCityTime('2020-03-11')));
        $I->assertTrue($event3->isActive());
    }

    /**
     * @before resetDatabase
     */
    public function testDeleteLastDateWithNextWeeklyPrior(UnitTester $I)
    {
        $shippingEvent = $this->createShipment->recurring(
            2,
            new RapidCityTime('2020-01-15'),
            new RapidCityTime('2020-03-25'),
            new RapidCityTime('2020-02-12')
        );
        $this->deleteDateInRecurringEvent->delete($shippingEvent, new RapidCityTime('2020-03-25'));

        [$event1, $event2] = $this->saveShippingEvent->getSortedEvents();

        /**
         * 2020-01-15 - 2020-03-11, active, next weekly 2020-02-12
         * 2020-03-25 - 2020-03-25, not active, no next weekly
         */
        $I->assertTrue($event1->getStartDate()->eq(new RapidCityTime('2020-01-15')));
        $I->assertTrue($event1->getEndDate()->eq(new RapidCityTime('2020-03-11')));
        $I->assertTrue($event1->getNextWeekly()->eq(new RapidCityTime('2020-02-12')));
        $I->assertTrue($event1->isActive());

        $I->assertTrue($event2->getStartDate()->eq(new RapidCityTime('2020-03-25')));
        $I->assertTrue($event2->getEndDate()->eq(new RapidCityTime('2020-03-25')));
        $I->assertNull($event2->getNextWeekly());
        $I->assertFalse($event2->isActive());
    }

    /**
     * @before resetDatabase
     */
    public function testDeleteLastDateWithNextWeeklyLastDate(UnitTester $I)
    {
        $shippingEvent = $this->createShipment->recurring(
            2,
            new RapidCityTime('2020-01-15'),
            new RapidCityTime('2020-03-25'),
            new RapidCityTime('2020-03-25')
        );
        $this->deleteDateInRecurringEvent->delete($shippingEvent, new RapidCityTime('2020-03-25'));

        [$event1, $event2] = $this->saveShippingEvent->getSortedEvents();

        /**
         * 2020-01-15 - 2020-03-11, not active, no next weekly
         * 2020-03-25 - 2020-03-25, not active, no next weekly
         */
        $I->assertTrue($event1->getStartDate()->eq(new RapidCityTime('2020-01-15')));
        $I->assertTrue($event1->getEndDate()->eq(new RapidCityTime('2020-03-11')));
        $I->assertNull($event1->getNextWeekly());
        $I->assertFalse($event1->isActive());

        $I->assertTrue($event2->getStartDate()->eq(new RapidCityTime('2020-03-25')));
        $I->assertTrue($event2->getEndDate()->eq(new RapidCityTime('2020-03-25')));
        $I->assertNull($event2->getNextWeekly());
        $I->assertFalse($event2->isActive());
    }

    /**
     * @before resetDatabase
     */
    public function testDeleteInSeriesWithDeletion(UnitTester $I)
    {
        $startingEvent = $this->createShipment->recurring(
            2,
            new RapidCityTime('2020-01-15'),
            new RapidCityTime('2020-04-22'),
            new RapidCityTime('2020-02-12')
        );
        $this->deleteDateInRecurringEvent->delete($startingEvent, new RapidCityTime('2020-03-25'));
        $events = $this->saveShippingEvent->getSortedEvents();
        $I->assertCount(3, $events);

        [$event1, $event2, $event3] = $events;

        /**
         * 2020-01-15 - 2020-03-11, active, next weekly 2020-02-12
         * 2020-03-25 - 2020-03-25, not active, no next weekly
         * 2020-04-08 - 2020-04-22, active, next weekly 2020-04-08
         */
        $I->assertTrue($event1->getStartDate()->eq(new RapidCityTime('2020-01-15')));
        $I->assertTrue($event1->getEndDate()->eq(new RapidCityTime('2020-03-11')));
        $I->assertTrue($event1->isActive());
        $I->assertTrue($event1->getNextWeekly()->eq(new RapidCityTime('2020-02-12')));

        $I->assertTrue($event2->getStartDate()->eq(new RapidCityTime('2020-03-25')));
        $I->assertTrue($event2->getEndDate()->eq(new RapidCityTime('2020-03-25')));
        $I->assertFalse($event2->isActive());
        $I->assertNull($event2->getNextWeekly());

        $I->assertTrue($event3->getStartDate()->eq(new RapidCityTime('2020-04-08')));
        $I->assertTrue($event3->getEndDate()->eq(new RapidCityTime('2020-04-22')));
        $I->assertTrue($event3->isActive());
        $I->assertTrue($event3->getNextWeekly()->eq(new RapidCityTime('2020-04-08')));

        $this->deleteDateInRecurringEvent->delete($event1, new RapidCityTime('2020-02-12'));

        $events = $this->saveShippingEvent->getSortedEvents();

        [$event1, $event2, $event3, $event4, $event5] = $events;

        /**
         * 2020-01-15 - 2020-01-29, not active, no next weekly
         * 2020-02-12 - 2020-02-12, not active, no next weekly
         * 2020-02-26 - 2020-03-11, active, next weekly 2020-02-26
         * 2020-03-25 - 2020-03-25, not active, no next weekly
         * 2020-04-08 - 2020-04-22, active, next weekly 2020-04-08
         */
        $I->assertTrue($event1->getStartDate()->eq(new RapidCityTime('2020-01-15')));
        $I->assertTrue($event1->getEndDate()->eq(new RapidCityTime('2020-01-29')));
        $I->assertFalse($event1->isActive());
        $I->assertNull($event1->getNextWeekly());

        $I->assertTrue($event2->getStartDate()->eq(new RapidCityTime('2020-02-12')));
        $I->assertTrue($event2->getEndDate()->eq(new RapidCityTime('2020-02-12')));
        $I->assertFalse($event2->isActive());
        $I->assertNull($event2->getNextWeekly());

        $I->assertTrue($event3->getStartDate()->eq(new RapidCityTime('2020-02-26')));
        $I->assertTrue($event3->getEndDate()->eq(new RapidCityTime('2020-03-11')));
        $I->assertTrue($event3->isActive());
        $I->assertTrue($event3->getNextWeekly()->eq(new RapidCityTime('2020-02-26')));

        $I->assertTrue($event4->getStartDate()->eq(new RapidCityTime('2020-03-25')));
        $I->assertTrue($event4->getEndDate()->eq(new RapidCityTime('2020-03-25')));
        $I->assertFalse($event4->isActive());
        $I->assertNull($event4->getNextWeekly());

        $I->assertTrue($event5->getStartDate()->eq(new RapidCityTime('2020-04-08')));
        $I->assertTrue($event5->getEndDate()->eq(new RapidCityTime('2020-04-22')));
        $I->assertTrue($event5->isActive());
        $I->assertTrue($event5->getNextWeekly()->eq(new RapidCityTime('2020-04-08')));
    }

    protected function resetDatabase(UnitTester $I)
    {
        $this->saveShippingEvent->reset();
    }
}
