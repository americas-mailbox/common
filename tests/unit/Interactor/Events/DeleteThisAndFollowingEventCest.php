<?php
declare(strict_types=1);

namespace Unit\Interactor\Events;

use AMB\Interactor\RapidCityTime;
use AMB\Interactor\ShippingEvent\DeleteThisAndFollowingEvent;
use Helper\Mock\SaveShippingEvent;
use Helper\Setup\CreateRecurringShipment;
use UnitTester;

class DeleteThisAndFollowingEventCest
{
    /** @var \Helper\Setup\CreateRecurringShipment */
    private $createShipment;
    /** @var \AMB\Interactor\ShippingEvent\DeleteThisAndFollowingEvent */
    private $deleteThisAndFollowingEvent;
    /** @var \Helper\Mock\SaveShippingEvent */
    private $saveShippingEvent;

    protected function _inject(SaveShippingEvent $saveShippingEvent)
    {
        $this->saveShippingEvent = $saveShippingEvent;

        $this->deleteThisAndFollowingEvent = new DeleteThisAndFollowingEvent($this->saveShippingEvent);
        $this->createShipment = new CreateRecurringShipment($saveShippingEvent);
    }

    public function testDeleteOnStartDate(UnitTester $I)
    {
        $shippingEvent = $this->createShipment->weekly();

        $this->deleteThisAndFollowingEvent->delete($shippingEvent, new RapidCityTime('2020-01-29'));

        $events = $this->saveShippingEvent->getSortedEvents();
        $I->assertCount(1, $events);
        [$event1] = $events;

        $I->assertFalse($event1->isActive());
        $I->assertTrue($event1->getStartDate()->eq(new RapidCityTime('2020-01-29')));
        $I->assertTrue($event1->getEndDate()->eq(new RapidCityTime('2020-02-26')));
        $I->assertNull($event1->getNextWeekly());
    }

    public function testDeleteOnEndDate(UnitTester $I)
    {
        $shippingEvent = $this->createShipment->weekly();

        $this->deleteThisAndFollowingEvent->delete($shippingEvent, new RapidCityTime('2020-02-26'));

        $events = $this->saveShippingEvent->getSortedEvents();
        $I->assertCount(2, $events);
        [$event1, $event2] = $events;

        $I->assertTrue($event1->isActive());
        $I->assertTrue($event1->getStartDate()->eq(new RapidCityTime('2020-01-29')));
        $I->assertTrue($event1->getEndDate()->eq(new RapidCityTime('2020-02-19')));
        $I->assertTrue($event1->getNextWeekly()->eq(new RapidCityTime('2020-02-12')));

        $I->assertFalse($event2->isActive());
        $I->assertTrue($event2->getStartDate()->eq(new RapidCityTime('2020-02-26')));
        $I->assertTrue($event2->getEndDate()->eq(new RapidCityTime('2020-02-26')));
        $I->assertNull($event2->getNextWeekly());
    }

    public function testDeleteBeforeNextWeekly(UnitTester $I)
    {
        $shippingEvent = $this->createShipment->weekly();

        $this->deleteThisAndFollowingEvent->delete($shippingEvent, new RapidCityTime('2020-02-05'));

        $events = $this->saveShippingEvent->getSortedEvents();
        $I->assertCount(2, $events);
        [$event1, $event2] = $events;

        $I->assertTrue($event1->isActive());
        $I->assertTrue($event1->getStartDate()->eq(new RapidCityTime('2020-01-29')));
        $I->assertTrue($event1->getEndDate()->eq(new RapidCityTime('2020-01-29')));
        $I->assertNull($event1->getNextWeekly());

        $I->assertFalse($event2->isActive());
        $I->assertTrue($event2->getStartDate()->eq(new RapidCityTime('2020-02-05')));
        $I->assertTrue($event2->getEndDate()->eq(new RapidCityTime('2020-02-26')));
        $I->assertNull($event2->getNextWeekly());
    }

    public function testDeleteOnNextWeekly(UnitTester $I)
    {
        $shippingEvent = $this->createShipment->weekly();

        $this->deleteThisAndFollowingEvent->delete($shippingEvent, new RapidCityTime('2020-02-12'));

        $events = $this->saveShippingEvent->getSortedEvents();
        $I->assertCount(2, $events);
        [$event1, $event2] = $events;

        $I->assertTrue($event1->isActive());
        $I->assertTrue($event1->getStartDate()->eq(new RapidCityTime('2020-01-29')));
        $I->assertTrue($event1->getEndDate()->eq(new RapidCityTime('2020-02-05')));
        $I->assertNull($event1->getNextWeekly());

        $I->assertFalse($event2->isActive());
        $I->assertTrue($event2->getStartDate()->eq(new RapidCityTime('2020-02-12')));
        $I->assertTrue($event2->getEndDate()->eq(new RapidCityTime('2020-02-26')));
        $I->assertNull($event2->getNextWeekly());
    }

    public function testDeleteAfterNextWeekly(UnitTester $I)
    {
        $shippingEvent = $this->createShipment->weekly();

        $this->deleteThisAndFollowingEvent->delete($shippingEvent, new RapidCityTime('2020-02-19'));

        $events = $this->saveShippingEvent->getSortedEvents();
        $I->assertCount(2, $events);
        [$event1, $event2] = $events;

        $I->assertTrue($event1->isActive());
        $I->assertTrue($event1->getStartDate()->eq(new RapidCityTime('2020-01-29')));
        $I->assertTrue($event1->getEndDate()->eq(new RapidCityTime('2020-02-12')));
        $I->assertTrue($event1->getNextWeekly()->eq(new RapidCityTime('2020-02-12')));

        $I->assertFalse($event2->isActive());
        $I->assertTrue($event2->getStartDate()->eq(new RapidCityTime('2020-02-19')));
        $I->assertTrue($event2->getEndDate()->eq(new RapidCityTime('2020-02-26')));
        $I->assertNull($event2->getNextWeekly());
    }
}
