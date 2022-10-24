<?php
declare(strict_types=1);

namespace AMB\Interactor\ShippingEvent;

use AMB\Entity\Shipping\ShippingEvent;

final class FindRecurringShippingEvent
{
    public function __construct(
        private FindShippingEventById $findShippingEventById,
    ) {}

    public function find(array $data): ?ShippingEvent
    {
        $idParts = explode('-', (string)$data['id']);
        $shippingEventId = $idParts[0];

        return $this->findShippingEventById->find($shippingEventId);
    }
}
