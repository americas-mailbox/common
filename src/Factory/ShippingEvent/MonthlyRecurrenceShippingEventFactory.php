<?php
declare(strict_types=1);

namespace AMB\Factory\ShippingEvent;

use AMB\Entity\Shipping\RecurrenceType;
use AMB\Entity\Shipping\ShippingEvent;

final class MonthlyRecurrenceShippingEventFactory extends BaseRecurringShippingEventFactory
{
    public function __invoke(array $data): ShippingEvent
    {
        if (!isset($data['dayOfTheMonth'])) {
            $data['dayOfTheMonth'] = explode('-', $data['date'])[2];
        }

        return $this->createRecurringEvent($data)
            ->setDayOfTheMonth((int)$data['dayOfTheMonth'])
            ->setRecurrenceType(RecurrenceType::MONTHLY());
    }
}
