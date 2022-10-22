<?php
declare(strict_types=1);

namespace AMB\Interactor\ShippingEvent;

use AMB\Entity\Shipping\ShippingEvent;
use Exception;

final class UpdateRecurringEvent
{
    public function __construct(
        private UpdateEvent $updateEvent,
        private UpdateThisAndFollowingEvents $updateThisAndFollowingEvents,
        private UpdateOnlyThisEvent $updateOnlyThisEvent,
    ) {}

    public function update(ShippingEvent $shippingEvent, array $data): array
    {
        if ($this->isAllEventsTypes($data)) {
            return $this->updateEvent->update($shippingEvent, $data);
        }
        if ($this->isThisAndFollowingEventsTypes($data)) {
            return $this->updateThisAndFollowingEvents->update($shippingEvent, $data);
        }
        if ($this->isOnlyThisEventType($data)) {
            return $this->updateOnlyThisEvent->update($shippingEvent, $data);
        }
        throw new Exception("Unknown recurrence type \"{$data['recurrenceModificationType']}\"");
    }

    private function isAllEventsTypes(array $data): bool
    {
        return 'allEvents' === $data['recurrenceModificationType'];
    }

    private function isOnlyThisEventType(array $data): bool
    {
        return 'thisEvent' === $data['recurrenceModificationType'];
    }

    private function isThisAndFollowingEventsTypes(array $data): bool
    {
        return 'thisAndFollowingEvents' === $data['recurrenceModificationType'];
    }
}
