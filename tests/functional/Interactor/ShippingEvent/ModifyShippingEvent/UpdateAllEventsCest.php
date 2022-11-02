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

class UpdateAllEventsCest extends SaveShippingEventBase
{
    public function testUpdateAddress(FunctionalTester $I)
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
            "deliveryMethodId"           => 5,
            "endDate"                    => "2100-01-01",
            "id"                         => $id,
            "memberId"                   => 1,
            "recurrence"                 => "weekly",
            "recurrenceEnding"           => "infinite",
            "recurrenceModificationType" => "allEvents",
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

        $updatedEvent = $this->getShippingEventData($shippingEvent);
        $I->assertSame("2", $updatedEvent['address_id']);

        // assert only one entry
        $eventData = $this->getShippingEventDataForMember(1);
        $I->assertEquals(1, count($eventData));
    }

    public function testUpdateShippingMethod(FunctionalTester $I)
    {
        $shippingEvent = $this->setUpEvent();
        $id = $shippingEvent->getId();

        $update = [
            "addressId"                  => 1,
            "deliveryGroup"              => "shipping",
            "date"                       => "2021-06-01",
            "deliveryMethod"             => [
                "id"    => 15,
                "label" => "First Class (if available)",
            ],
            "deliveryMethodId"           => 15,
            "endDate"                    => "2100-01-01",
            "id"                         => $id,
            "memberId"                   => 1,
            "recurrence"                 => "weekly",
            "recurrenceEnding"           => "infinite",
            "recurrenceModificationType" => "allEvents",
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

        $updatedEvent = $this->getShippingEventData($shippingEvent);
        $I->assertSame("15", $updatedEvent['delivery_id']);
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
