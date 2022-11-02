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

class DeleteAllEventsCest extends SaveShippingEventBase
{
    public function testDelete(FunctionalTester $I)
    {
        $shippingEvent = $this->setUpEvent();
        $id = $shippingEvent->getId();
        $update = [
            "addressId"                  => 1,
            "deliveryGroup"              => "shipping",
            "date"                       => "2021-05-26",
            "delete"                     => true,
            "deliveryMethod"             => [
                "id"    => 5,
                "label" => "Best Method",
            ],
            "deliveryMethodId"           => 5,
            "endDate"                    => "2021-05-26",
            "id"                         => $id,
            "memberId"                   => 1,
            "recurrence"                 => "weekly",
            "recurrenceEnding"           => "infinite",
            "recurrenceModificationType" => "allEvents",
            "startDate"                  => "2021-05-26",
            "trackingNumber"             => null,
            "trackingUrl"                => null,
            "type"                       => "event",
            "wasPickedUp"                => false,
            "wasShipped"                 => false,
            "weeksBetween"               => null,
        ];

        /** @var UpdateRecurringEvent $updateRecurringEvent */
        $updateRecurringEvent = $this->container->get(UpdateRecurringEvent::class);
        $updateRecurringEvent->update($shippingEvent, $update);

        $updatedEvent = $this->getShippingEventData($shippingEvent);
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
