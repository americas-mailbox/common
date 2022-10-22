<?php
declare(strict_types=1);

namespace AMB\Factory\ShippingEvent;

use AMB\Entity\Shipping\RecurrenceType;
use AMB\Entity\Shipping\ShippingEvent;

final class DailyRecurrenceShippingEventFactory extends BaseRecurringShippingEventFactory
{
    public function __invoke(array $data): ShippingEvent
    {
        return $this->createRecurringEvent($data)
            ->setDaily(true)
            ->setRecurrenceType(RecurrenceType::DAILY());
    }
}
