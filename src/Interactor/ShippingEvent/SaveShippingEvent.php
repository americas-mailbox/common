<?php
declare(strict_types=1);

namespace AMB\Interactor\ShippingEvent;

use AMB\Entity\ActionType;
use AMB\Entity\Shipping\RecurrenceType;
use AMB\Entity\Shipping\ShippingEvent;
use AMB\Interactor\Shipping\FindShippingEventById;
use AMB\Interfaces\ShippingEvent\SaveShippingEventInterface;
use App\Factory\Event\LogShipmentEventFactory;
use Doctrine\DBAL\Connection;
use Exception;
use IamPersistent\SimpleShop\Interactor\DBal\BoolToSQL;
use IamPersistent\SimpleShop\Interactor\ObjectHasId;

final class SaveShippingEvent implements SaveShippingEventInterface
{
    public function __construct(
        private Connection $connection,
        private FindShippingEventById $findShippingEventById,
        private LogShipmentEventFactory $logShippingEventFactory,
    ) { }

    public function save(ShippingEvent $shippingEvent)
    {
        if ((new ObjectHasId)($shippingEvent)) {
            if ($this->updateData($shippingEvent)) {
                // object after update
                $updatedShipmentEventHydratedObject = $this->findShippingEventById->find($shippingEvent->getId());
                if (!$updatedShipmentEventHydratedObject->isActive()) {
                    // Dispatch ChangeInShipmentEvent for delete
                    $this->logShippingEventFactory->dispatch($updatedShipmentEventHydratedObject, new ActionType(ActionType::DELETED));
                } else {
                    // Dispatch ChangeInShipmentEvent for update
                    $this->logShippingEventFactory->dispatch($updatedShipmentEventHydratedObject, new ActionType(ActionType::UPDATED));
                }
            }
        } else {
            if ($this->insertData($shippingEvent)) { // successfully saved
                //load complete new shipment object.
                $shipmentEventHydratedObject = $this->findShippingEventById->find($shippingEvent->getId());
                // @todo: Not sure why but it is being executed when we delete in between shipment from series of shipments.
                if(!$shipmentEventHydratedObject->isActive()) {
                    // Dispatch ChangeInShipmentEvent for delete
                    $this->logShippingEventFactory->dispatch($shipmentEventHydratedObject, new ActionType(ActionType::DELETED));
                } else {
                    // Dispatch NewShippingEvent.
                    $this->logShippingEventFactory->dispatch($shipmentEventHydratedObject, new ActionType(ActionType::CREATED));
                }
            }
        }
    }

    private function insertData(ShippingEvent $shippingEvent): bool
    {
        $data = $this->prepDataForPersistence($shippingEvent);

        try {
            $this->connection->beginTransaction();
            $response = $this->connection->insert('shipping_events', $data);
            if (1 !== $response) {
                throw new Exception();
            }
            $id = (int)$this->connection->lastInsertId();
            $shippingEvent->setId($id);

        } catch (Exception $e) {
            $this->connection->rollBack();

            return false;
        }

        return $this->connection->commit();
    }

    private function updateData(ShippingEvent $shippingEvent)
    {
        $data = $this->prepDataForPersistence($shippingEvent);

        try {
            $this->connection->beginTransaction();
            $response = $this->connection->update('shipping_events', $data, ['id' => $shippingEvent->getId()]);
        } catch (Exception $e) {
            $this->connection->rollBack();

            return false;
        }

        return $this->connection->commit();
    }

    private function prepDataForPersistence(ShippingEvent $shippingEvent)
    {
        $getIdOrNull = function($object = null) {
            return $object ? $object->getId() : null;
        };
        $addressId = $getIdOrNull($shippingEvent->getAddress());

        $getValueOrNull = function($enum = null) {
            return $enum ? $enum->getValue() : null;
        };

        if ($shippingEvent->getStartDate()->eq($shippingEvent->getEndDate())) {
            $recurrenceType = RecurrenceType::DOES_NOT_REPEAT;
        } else {
            $recurrenceType = (string)$shippingEvent->getRecurrenceType();
            $dayOfTheWeek = $getValueOrNull($shippingEvent->getDayOfTheWeek());
            $firstWeekDayOfTheMonth = $getValueOrNull($shippingEvent->getFirstWeekdayOfTheMonth());
            $lastWeekDayOfTheMonth = $getValueOrNull($shippingEvent->getLastWeekdayOfTheMonth());
            $nextWeekly = $shippingEvent->getNextWeekly() ? $shippingEvent->getNextWeekly()->toDateString() : null;
        }

        return [
            'address_id'                 => $addressId,
            'daily'                      => (int)$shippingEvent->isDaily(),
            'day_of_the_month'           => $shippingEvent->getDayOfTheMonth(),
            'day_of_the_week'            => $dayOfTheWeek ?? null,
            'delivery_id'                => $shippingEvent->getDeliveryMethod()->getId(),
            'first_weekday_of_the_month' => $firstWeekDayOfTheMonth ?? null,
            'end_date'                   => $shippingEvent->getEndDate()->toDateString(),
            'is_active'                  => (new BoolToSQL)($shippingEvent->isActive()),
            'last_weekday_of_the_month'  => $lastWeekDayOfTheMonth ?? null,
            'member_id'                  => $shippingEvent->getMember()->getId(),
            'next_weekly'                => $nextWeekly ?? null,
            'recurrence_type'            => $recurrenceType,
            'start_date'                 => $shippingEvent->getStartDate()->toDateString(),
            'weeks_between'              => $shippingEvent->getWeeksBetween(),
        ];
    }
}
