<?php
declare(strict_types=1);

namespace ShippingEvent\ModifyShippingEvent;

use AMB\Entity\MySQLBoolean;
use AMB\Entity\Shipping\RecurrenceType;
use AMB\Entity\Shipping\ShippingEvent;
use AMB\Interactor\RapidCityTime;
use AMB\Interactor\ShippingEvent\UpdateOneTimeEvent;
use FunctionalTester;
use ShippingEvent\SaveShippingEventBase;

class DeleteOneTimeEventCest extends SaveShippingEventBase
{
    public function testDelete(FunctionalTester $I)
    {
        $shippingEvent = $this->setUpEvent();
        $id = $shippingEvent->getId();

        $update = [
            "addressId"        => 1,
            "deliveryGroup"    => "shipping",
            "date"             => "2021-05-26",
            "delete"            => true,
            "deliveryMethod"   => [
                "id"    => 5,
                "label" => "Best Method",
            ],
            "deliveryMethodId" => 5,
            "endDate"          => "2021-05-26",
            "id"               => $id,
            "memberId"         => 1,
            "recurrence"       => "doesNotRepeat",
            "recurrenceEnding" => "finite",
            "startDate"        => "2021-05-26",
            "trackingNumber"   => null,
            "trackingUrl"      => null,
            "type"             => "event",
            "wasPickedUp"      => false,
            "wasShipped"       => false,
            "weeksBetween"     => null,
        ];

        /** @var UpdateOneTimeEvent $modifyEvent */
        $modifyEvent = $this->container->get(UpdateOneTimeEvent::class);
        $modifyEvent->update($shippingEvent, $update);

        $updatedEvent = $this->getShippingEventData($shippingEvent);
        $I->assertEquals(MySQLBoolean::FALSE, $updatedEvent['is_active']);
    }

    private function setUpEvent(): ShippingEvent
    {
        $date = new RapidCityTime('2021-08-30');

        $shippingEvent = $this->getShippingEvent()
            ->setActive(true)
            ->setRecurrenceType(RecurrenceType::DOES_NOT_REPEAT())
            ->setEndDate($date)
            ->setStartDate($date);
        $this->saveShippingEvent->save($shippingEvent);

        return $shippingEvent;
    }
}
