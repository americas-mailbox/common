<?php
declare(strict_types=1);

namespace AMB\Interactor\Shipping;

use AMB\Entity\Address;
use AMB\Entity\Member;
use AMB\Entity\Shipping\DeliveryMethod;
use AMB\Entity\Shipping\Shipment;
use Carbon\Carbon;

final class CreateShipment
{
    public function __construct(
        private SaveShipment $saveShipment,
    ) {
    }

    public function create(Member $member, Address $address, DeliveryMethod $deliveryMethod, Carbon $date): Shipment
    {
        $shipment = (new Shipment())
            ->setAddress($address)
            ->setDate($date)
            ->setDeliveryMethod($deliveryMethod)
            ->setFulfilled(false)
            ->setMember($member);

        $this->saveShipment->save($shipment);

        return $shipment;
    }
}
