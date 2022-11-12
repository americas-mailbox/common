<?php
declare(strict_types=1);

namespace Unit\Interactor\Events;

use AMB\Interactor\RapidCityTime;
use AMB\Interactor\ShippingEvent\DeleteAllEvents;
use Helper\Mock\SaveShippingEvent;
use Helper\Setup\CreateRecurringShipment;
use UnitTester;

class DeleteAllEventsCest
{
    /** @var \Helper\Setup\CreateRecurringShipment */
    private $createShipment;
    /** @var \AMB\Interactor\ShippingEvent\DeleteAllEvents */
    private $deleteAll;
    /** @var \Helper\Mock\SaveShippingEvent */
    private $saveShippingEvent;

    protected function _inject(SaveShippingEvent $saveShippingEvent)
    {
        $this->saveShippingEvent = $saveShippingEvent;

        $this->deleteAll = new DeleteAllEvents($this->saveShippingEvent);
        $this->createShipment = new CreateRecurringShipment($saveShippingEvent);
    }

    public function testDelete(UnitTester $I)
    {
        $shippingEvent = $this->createShipment->weekly();

        $this->deleteAll->delete($shippingEvent);

        $events = $this->saveShippingEvent->getSortedEvents();
        $I->assertCount(1, $events);
        [$event1] = $events;

        $I->assertFalse($event1->isActive());
        $I->assertTrue($event1->getStartDate()->eq(new RapidCityTime('2020-01-29')));
        $I->assertTrue($event1->getEndDate()->eq(new RapidCityTime('2020-02-26')));
        $I->assertTrue($event1->getNextWeekly()->eq(new RapidCityTime('2020-02-12')));
    }
}
