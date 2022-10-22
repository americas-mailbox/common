<?php
declare(strict_types=1);

namespace AMB\Interactor\ShippingEvent;

use AMB\Entity\Shipping\ShippingEvent;

final class UpdateOneTimeEvent
{
    public function __construct(
        private DeleteOneTimeEvent $deleteOneTimeEvent,
        private UpdateEvent $updateEvent,
    ) {}

    public function update(ShippingEvent $shippingEvent, array $data): array
    {
        if ((new ShouldDeleteEvent)($data)) {
            $this->deleteOneTimeEvent->delete($shippingEvent);

            return ['id' => $data['id']];
        }

        return $this->updateEvent->update($shippingEvent, $data);
    }
}
