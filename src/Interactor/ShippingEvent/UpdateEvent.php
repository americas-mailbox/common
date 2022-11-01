<?php
declare(strict_types=1);

namespace AMB\Interactor\ShippingEvent;

use AMB\Entity\Address;
use AMB\Entity\Shipping\DeliveryMethod;
use AMB\Entity\Shipping\ShippingEvent;

final class UpdateEvent
{
    public function __construct(
        private DeleteAllEvents $deleteAllEvents,
        private SaveShippingEvent $saveShippingEvent,
    ) {}

    public function update(ShippingEvent $shippingEvent, array $data): array
    {
        if ('pickup' === $data['deliveryGroup']) {
            $address = (new Address())->setId(1); // pick up address
            $deliveryMethod = (new DeliveryMethod())->setId(7); // pick up method
        } else {
            $address = (new Address())->setId($data['addressId']);
            $deliveryMethod = (new DeliveryMethod())->setId($data['deliveryMethodId']);
        }

        $shippingEvent
            ->setAddress($address)
            ->setDeliveryMethod($deliveryMethod);
        $this->saveShippingEvent->save($shippingEvent);

        if ((new ShouldDeleteEvent)($data)) {
            return $this->deleteAllEvents->delete($shippingEvent);
        }

        return ['id' => $data['id']];
    }
}
