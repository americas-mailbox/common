<?php
declare(strict_types=1);

namespace ShippingEvent;

use AMB\Entity\Shipping\DayOfTheWeek;
use AMB\Entity\Shipping\RecurrenceType;
use AMB\Entity\Shipping\ShippingEvent;
use AMB\Interactor\RapidCityTime;
use AMB\Interactor\ShippingEvent\CloneEvent;
use Codeception\Util\ReflectionHelper;
use FunctionalTester;

class CloneEventCest extends SaveShippingEventBase
{
    public function testClone(FunctionalTester $I)
    {
        $shippingEvent = $this->setUpEvent();
        $clone = (new CloneEvent())->clone($shippingEvent);
        $id = ReflectionHelper::readPrivateProperty($clone, 'id');
        $I->assertNull($id);
    }

    public function testSplit(FunctionalTester $I)
    {
        $shippingEvent = $this->setUpEvent();
        $clone = (new CloneEvent())->split($shippingEvent, new RapidCityTime('2021-06-15'));
        $I->assertTrue((new RapidCityTime('2021-06-01'))->eq($shippingEvent->getStartDate()));
        $I->assertTrue((new RapidCityTime('2021-06-08'))->eq($shippingEvent->getEndDate()));
        $I->assertTrue((new RapidCityTime('2021-06-15'))->eq($clone->getStartDate()));
        $I->assertTrue((new RapidCityTime('2100-01-01'))->eq($clone->getEndDate()));
    }

    private function setUpEvent(): ShippingEvent
    {
        $shippingEvent = $this->getShippingEvent()
            ->setActive(true)
            ->setDayOfTheWeek(DayOfTheWeek::TUESDAY())
            ->setEndDate(new RapidCityTime('2100-01-01'))
            ->setRecurrenceType(RecurrenceType::WEEKLY())
            ->setStartDate(new RapidCityTime('2021-06-01'));
        $this->saveShippingEvent->save($shippingEvent);

        return $shippingEvent;
    }
}
