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

class UpdateOnlyThisEventCest extends SaveShippingEventBase
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
            "recurrenceModificationType" => "thisEvent",
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
        $I->assertSame("2021-06-08", $currentEvent['start_date']);
        $I->assertSame("2100-01-01", $currentEvent['end_date']);

        $updatedEvent = $this->getUpdatedEvent($eventData, $id);
        $I->assertSame("2", $updatedEvent['address_id']);
        $I->assertSame("15", $updatedEvent['delivery_id']);
        $I->assertSame("2021-06-01", $updatedEvent['start_date']);
        $I->assertSame("2021-06-01", $updatedEvent['end_date']);
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
            "recurrenceModificationType" => "thisEvent",
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
        $I->assertEquals(3, count($eventData));

        $currentEvent = $this->getCurrentEvent($eventData, $id);
        $I->assertSame(RecurrenceType::WEEKLY, $currentEvent['recurrence_type']);
        $I->assertSame("1", $currentEvent['address_id']);
        $I->assertSame("5", $currentEvent['delivery_id']);
        $I->assertSame("2021-06-01", $currentEvent['start_date']);
        $I->assertSame("2021-06-08", $currentEvent['end_date']);

        $oneTime = $this->getOneTimeEvent($eventData);
        $I->assertSame(RecurrenceType::DOES_NOT_REPEAT, $oneTime['recurrence_type']);
        $I->assertSame("2", $oneTime['address_id']);
        $I->assertSame("15", $oneTime['delivery_id']);
        $I->assertSame("2021-06-15", $oneTime['start_date']);
        $I->assertSame("2021-06-15", $oneTime['end_date']);

        $clonedEvent = $this->getClonedEvent($eventData, $id);
        $I->assertSame(RecurrenceType::WEEKLY, $clonedEvent['recurrence_type']);
        $I->assertSame("1", $clonedEvent['address_id']);
        $I->assertSame("5", $clonedEvent['delivery_id']);
        $I->assertSame("2021-06-22", $clonedEvent['start_date']);
        $I->assertSame("2100-01-01", $clonedEvent['end_date']);
    }

    public function testUpdateChangeFromLastDate(FunctionalTester $I)
    {
        $I->truncateTable('shipping_events');
        $shippingEvent = $this->setUpLastDateEvent();
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
            "date"                       => "2021-06-29",
            "deliveryMethod"             => [
                "id"    => 5,
                "label" => "Best Method",
            ],
            "deliveryMethodId"           => 15,
            "endDate"                    => "2021-06-29",
            "id"                         => $id,
            "memberId"                   => 1,
            "recurrence"                 => "weekly",
            "recurrenceEnding"           => "infinite",
            "recurrenceModificationType" => "thisEvent",
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
        $I->assertSame(RecurrenceType::WEEKLY, $currentEvent['recurrence_type']);
        $I->assertSame("1", $currentEvent['address_id']);
        $I->assertSame("5", $currentEvent['delivery_id']);
        $I->assertSame("2021-06-01", $currentEvent['start_date']);
        $I->assertSame("2021-06-22", $currentEvent['end_date']);

        $oneTime = $this->getOneTimeEvent($eventData);
        $I->assertSame(RecurrenceType::DOES_NOT_REPEAT, $oneTime['recurrence_type']);
        $I->assertSame("2", $oneTime['address_id']);
        $I->assertSame("15", $oneTime['delivery_id']);
        $I->assertSame("2021-06-29", $oneTime['start_date']);
        $I->assertSame("2021-06-29", $oneTime['end_date']);
    }

    private function getOneTimeEvent(array $data): array
    {
        foreach ($data as $datum) {
            if ($datum['recurrence_type'] === RecurrenceType::DOES_NOT_REPEAT) {
                return $datum;
            }
        }
    }

    private function getClonedEvent(array $data, $id): array
    {
        foreach ($data as $datum) {
            if ($datum['id'] != $id && $datum['recurrence_type'] !== RecurrenceType::DOES_NOT_REPEAT) {
                return $datum;
            }
        }
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

    private function setUpLastDateEvent(): ShippingEvent
    {
        $shippingEvent = $this->getShippingEvent()
            ->setActive(true)
            ->setDayOfTheWeek(DayOfTheWeek::TUESDAY())
            ->setEndDate(new RapidCityTime('2021-06-29'))
            ->setRecurrenceType(RecurrenceType::WEEKLY())
            ->setStartDate(new RapidCityTime('2021-06-01'));
        $this->saveShippingEvent->save($shippingEvent);

        return $shippingEvent;
    }
}
