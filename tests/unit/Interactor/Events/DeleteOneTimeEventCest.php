<?php
declare(strict_types=1);

namespace Unit\Interactor\Events;

use AMB\Entity\Shipping\ShippingEvent;
use AMB\Interactor\RapidCityTime;
use AMB\Interactor\ShippingEvent\DeleteOneTimeEvent;
use Helper\Mock\SaveShippingEvent;
use UnitTester;

class DeleteOneTimeEventCest
{
    /** @var \AMB\Interactor\ShippingEvent\DeleteOneTimeEvent */
    private $deleteOneTimeEvent;
    /** @var \Helper\Mock\SaveShippingEvent */
    private $saveShippingEvent;

    protected function _inject(SaveShippingEvent $saveShippingEvent)
    {
        $this->saveShippingEvent = $saveShippingEvent;

        $this->deleteOneTimeEvent = new DeleteOneTimeEvent($this->saveShippingEvent);
    }

    public function testDelete(UnitTester $I)
    {
        $date = new RapidCityTime('2020-02-26');
        $shippingEvent = (new ShippingEvent())
            ->setActive(true)
            ->setId(1)
            ->setStartDate($date)
            ->setEndDate($date);

        $this->deleteOneTimeEvent->delete($shippingEvent);

        $events = $this->saveShippingEvent->getEvents();
        $I->assertCount(1, $events);
        $I->assertFalse($shippingEvent->isActive());
    }
}
