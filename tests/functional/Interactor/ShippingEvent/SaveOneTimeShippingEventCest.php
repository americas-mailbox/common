<?php
declare(strict_types=1);

namespace ShippingEvent;

use AMB\Entity\Shipping\RecurrenceType;
use AMB\Entity\Shipping\ShippingEvent;
use AMB\Interactor\RapidCityTime;
use FunctionalTester;

class SaveOneTimeShippingEventCest extends SaveShippingEventBase
{
    public function testInsertOneTime(FunctionalTester $I)
    {
        $date = new RapidCityTime('2020-08-30');
        $shippingEvent = $this->getShippingEvent()
            ->setActive(true)
            ->setRecurrenceType(RecurrenceType::DOES_NOT_REPEAT())
            ->setEndDate($date)
            ->setStartDate($date);
        $this->saveShippingEvent->save($shippingEvent);

        $I->assertNotEmpty($shippingEvent->getId());
        $data = $this->getShippingEventData($shippingEvent);
        $I->assertEquals($this->expectedInsertData($shippingEvent), $data);
    }

    public function testUpdate(FunctionalTester $I)
    {
    }

    protected function expectedInsertData(ShippingEvent $shippingEvent): array
    {
        return [
            'address_id'                 => 1,
            'daily'                      => 0,
            'day_of_the_month'           => null,
            'day_of_the_week'            => null,
            'delivery_id'                => 5,
            'end_date'                   => '2020-08-30',
            'first_weekday_of_the_month' => null,
            'id'                         => $shippingEvent->getId(),
            'is_active'                  => 1,
            'last_weekday_of_the_month'  => null,
            'member_id'                  => 1,
            'next_weekly'                => null,
            'recurrence_type'            => RecurrenceType::DOES_NOT_REPEAT,
            'start_date'                 => '2020-08-30',
            'weeks_between'              => null,
            'recurrence_id'              => null,
        ];
    }
}
