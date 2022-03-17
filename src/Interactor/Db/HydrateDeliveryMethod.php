<?php
declare(strict_types=1);

namespace AMB\Interactor\Db;

use AMB\Entity\Shipping\DeliveryMethod;

final class HydrateDeliveryMethod
{
    public function __construct(
        private HydrateCarrier $hydrateCarrier,
    ) {}

    public function hydrate($data): DeliveryMethod
    {
        $deliveryMethod = (new DeliveryMethod())
            ->setGroup($data['group'])
            ->setLabel($data['label'])
            ->setShortLabel($data['shortLabel']);

        if (!empty($data['id'])) {
            $deliveryMethod->setId((int) $data['id']);
        }
        if (!empty($data['delivery_carrier'])) {
            $carrier = $this->hydrateCarrier->hydrate($data['delivery_carrier']);
            $deliveryMethod->setCarrier($carrier);
        }

        return $deliveryMethod;
    }
}
