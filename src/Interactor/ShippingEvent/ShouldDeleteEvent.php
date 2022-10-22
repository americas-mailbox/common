<?php
declare(strict_types=1);

namespace AMB\Interactor\ShippingEvent;

final class ShouldDeleteEvent
{
    public function __invoke($data): bool
    {
        return $data['delete'] ?? false;
    }
}
