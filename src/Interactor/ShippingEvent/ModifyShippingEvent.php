<?php
declare(strict_types=1);

namespace AMB\Interactor\ShippingEvent;

use AMB\Entity\Shipping\RecurrenceType;
use AMB\Entity\Shipping\ShippingEvent;
use Doctrine\DBAL\Connection;

final class ModifyShippingEvent
{
    public function __construct(
        private Connection $connection,
        private FindRecurringShippingEvent $findShippingEvent,
        private UpdateRecurringEvent $updateRecurringEvent,
        private UpdateOneTimeEvent $updateOneTimeEvent,
    ) {}

    public function updateFromApi(array $data, $adminId = null, $memberId): array
    {
        if (!$shippingEvent = $this->findShippingEvent->find($data)) {
            return [];
        }

        if ($shippingEvent->getMember()->getId() != $memberId) {
            return [];
        }
        $eventId = ['id' => $shippingEvent->getId()];
        $updatedBy = [
            'updated_by_admin_id'  => $adminId,
            'updated_by_member_id' => $memberId,
        ];
        $this->connection->update('shipping_events', $updatedBy, $eventId);

        if ($this->isOneTimeEvent($shippingEvent)) {
            return $this->updateOneTimeEvent->update($shippingEvent, $data);
        }

        return $this->updateRecurringEvent->update($shippingEvent, $data);
    }

    private function isOneTimeEvent(ShippingEvent $shippingEvent): bool
    {
        return $shippingEvent->getRecurrenceType()->equals(RecurrenceType::DOES_NOT_REPEAT());
    }
}
