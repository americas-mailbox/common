<?php
declare(strict_types=1);

namespace ShippingEvent\ModifyShippingEvent;

use AMB\Entity\MySQLBoolean;
use AMB\Entity\Shipping\DayOfTheWeek;
use AMB\Entity\Shipping\RecurrenceType;
use AMB\Entity\Shipping\ShippingEvent;
use AMB\Interactor\RapidCityTime;
use AMB\Interactor\ShippingEvent\UpdateRecurringEvent;
use FunctionalTester;
use ShippingEvent\SaveShippingEventBase;
use function Tests\Functional\Interactor\ShippingEvent\ModifyShippingEvent\count;

class DeleteThisAndFollowingEventsCest extends SaveShippingEventBase
{
    public function testUpdateChangeFromFirstDate(FunctionalTester $I)
    {
        $shippingEvent = $this->setUpEvent();
        $id = $shippingEvent->getId();

        $update = [
            "address"                    => [
                "addressee" => "Francesca Hull",
                "street1"   => "8707 Posuere Road",
                "city"      => "Lowell",
                "state"     => "MA",
                "post_code" => "01850",
                'country'   => 'US',
                'id'        => 2,
                'deleted'   => MySQLBoolean::FALSE,
                "plus4"     => null,
                "street2"   => "Apt 328",
                "street3"   => "",
                "verified"  => false,
            ],
            "addressId"                  => 2,
            "deliveryGroup"              => "shipping",
            "delete"                     => true,
            "date"                       => "2021-06-01",
            "deliveryMethod"             => [
                "id"    => 5,
                "label" => "Best Method",
            ],
            "deliveryMethodId"           => 15,
            "endDate"                    => "2100-01-01",
            "id"                         => $id,
            "memberId"                   => 1,
            "recurrence"                 => "weekly",
            "recurrenceEnding"           => "infinite",
            "recurrenceModificationType" => "thisAndFollowingEvents",
            "role"                       => "member",
            "startDate"                  => "2021-06-01",
            "trackingNumber"             => null,
            "trackingUrl"                => null,
            "type"                       => "event",
            "wasPickedUp"                => false,
            "wasShipped"                 => false,
            "weeksBetween"               => null,
        ];

        /** @var UpdateRecurringEvent $modifyEvent */
        $modifyEvent = $this->container->get(UpdateRecurringEvent::class);
        $modifyEvent->update($shippingEvent, $update);

        $eventData = $this->getShippingEventDataForMember(1);
        $I->assertEquals(1, count($eventData));

        $updatedEvent = $eventData[0];
        $I->assertEquals(MySQLBoolean::FALSE, $updatedEvent['is_active']);
    }

    public function testUpdateChange(FunctionalTester $I)
    {
        $I->truncateTable('shipping_events');
        $shippingEvent = $this->setUpEvent();
        $id = $shippingEvent->getId();

        $update = [
            "address"                    => [
                "addressee" => "Francesca Hull",
                "street1"   => "8707 Posuere Road",
                "city"      => "Lowell",
                "state"     => "MA",
                "post_code" => "01850",
                'country'   => 'US',
                'id'        => 2,
                'deleted'   => MySQLBoolean::FALSE,
                "plus4"     => null,
                "street2"   => "Apt 328",
                "street3"   => "",
                "verified"  => false,
            ],
            "addressId"                  => 2,
            "deliveryGroup"              => "shipping",
            "date"                       => "2021-06-15",
            "delete"                     => true,
            "deliveryMethod"             => [
                "id"    => 5,
                "label" => "Best Method",
            ],
            "deliveryMethodId"           => 15,
            "endDate"                    => "2100-01-01",
            "id"                         => $id,
            "memberId"                   => 1,
            "recurrence"                 => "weekly",
            "recurrenceEnding"           => "infinite",
            "recurrenceModificationType" => "thisAndFollowingEvents",
            "role"                       => "member",
            "startDate"                  => "2021-06-01",
            "trackingNumber"             => null,
            "trackingUrl"                => null,
            "type"                       => "event",
            "wasPickedUp"                => false,
            "wasShipped"                 => false,
            "weeksBetween"               => null,
        ];

        /** @var UpdateRecurringEvent $modifyEvent */
        $modifyEvent = $this->container->get(UpdateRecurringEvent::class);
        $modifyEvent->update($shippingEvent, $update);

        // assert two entries
        $eventData = $this->getShippingEventDataForMember(1);
        $I->assertEquals(2, count($eventData));

        $currentEvent = $this->getCurrentEvent($eventData, $id);
        $I->assertSame("1", $currentEvent['address_id']);
        $I->assertSame("5", $currentEvent['delivery_id']);
        $I->assertSame("2021-06-01", $currentEvent['start_date']);
        $I->assertSame("2021-06-08", $currentEvent['end_date']);

        $updatedEvent = $this->getUpdatedEvent($eventData, $id);
        $I->assertSame("1", $updatedEvent['address_id']);
        $I->assertSame("5", $updatedEvent['delivery_id']);
        $I->assertSame("2021-06-15", $updatedEvent['start_date']);
        $I->assertSame("2100-01-01", $updatedEvent['end_date']);
        $I->assertEquals(MySQLBoolean::FALSE, $updatedEvent['is_active']);
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
