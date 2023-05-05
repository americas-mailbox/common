<?php
declare(strict_types=1);

namespace AMB\View\ShippingEvent\Handler;

use AMB\Entity\Shipping\ShippingEvent;
use AMB\Interactor\RapidCityTime;

final class HandleDoesNotRepeat implements RecurrenceHandlerInterface
{
    public function __construct(
        private NormalizeShippingEvent $normalizeShippingEvent,
        private SetDateInEventData $setDateInEvent,
    ) { }

    public function handle(ShippingEvent $shippingEvent, RapidCityTime $startDate, RapidCityTime $endDate): array
    {
        $singleEvent = $this->normalizeShippingEvent->normalize($shippingEvent);
        $singleEvent['recurrence'] = 'doesNotRepeat';

        if ($startDate->gt($shippingEvent->getStartDate()) || $endDate->lt($shippingEvent->getEndDate())) {
            return [];
        }
        $dateString = $this->setDateInEvent->set($shippingEvent, $singleEvent, $shippingEvent->getStartDate());

        return [$dateString => $singleEvent];
    }
}
