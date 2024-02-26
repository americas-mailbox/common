<?php
declare(strict_types=1);

namespace AMB\Entity\Shipping;

use AMB\Entity\Address;
use AMB\Entity\Member;
use Carbon\Carbon;

final class Shipment
{
    /** @var \AMB\Entity\Address */
    private $address;
    /** @var \Carbon\Carbon */
    private $date;
    /** @var \AMB\Entity\Shipping\Delivery|null */
    private $delivery;
    /** @var \AMB\Entity\Shipping\DeliveryMethod */
    private $deliveryMethod;
    /** @var bool */
    private $fulfilled;
    /** @var \Carbon\Carbon | null */
    private $fulfilledDate;
    /** @var int | null */
    private $fulfilledLedgerItemId;
    /** @var mixed */
    private $id = null;
    /** @var \AMB\Entity\Member */
    private $member;
    /** @var string | null */
    private $vendorId;

    public function getAddress(): Address
    {
        return $this->address;
    }

    public function setAddress(Address $address): Shipment
    {
        $this->address = $address;

        return $this;
    }

    public function getDate(): Carbon
    {
        return $this->date;
    }

    public function setDate(Carbon $date): Shipment
    {
        $this->date = $date;

        return $this;
    }

    public function getDelivery(): ?Delivery
    {
        return $this->delivery;
    }

    public function setDelivery(Delivery $delivery): Shipment
    {
        $this->delivery = $delivery;

        return $this;
    }

    public function getDeliveryMethod(): DeliveryMethod
    {
        return $this->deliveryMethod;
    }

    public function setDeliveryMethod(DeliveryMethod $deliveryMethod): Shipment
    {
        $this->deliveryMethod = $deliveryMethod;

        return $this;
    }

    public function isFulfilled(): bool
    {
        return $this->fulfilled;
    }

    public function setFulfilled(bool $fulfilled): Shipment
    {
        $this->fulfilled = $fulfilled;

        return $this;
    }

    public function getFulfilledDate(): ?\Carbon\Carbon
    {
        return $this->fulfilledDate;
    }

    public function setFulfilledDate(?\Carbon\Carbon $fulfilledDate): Shipment
    {
        $this->fulfilledDate = $fulfilledDate;

        return $this;
    }

    public function getFulfilledLedgerItemId(): ?int
    {
        return $this->fulfilledLedgerItemId;
    }

    public function setFulfilledLedgerItemId(?int $fulfilledLedgerItemId): Shipment
    {
        $this->fulfilledLedgerItemId = $fulfilledLedgerItemId;

        return $this;
    }

    public function getId()
    {
        return $this->id;
    }

    public function setId($id): Shipment
    {
        $this->id = $id;

        return $this;
    }

    public function getMember(): Member
    {
        return $this->member;
    }

    public function setMember(Member $member): Shipment
    {
        $this->member = $member;

        return $this;
    }

    public function getVendorId(): ?string
    {
        return $this->vendorId;
    }

    public function setVendorId(?string $vendorId): Shipment
    {
        $this->vendorId = $vendorId;

        return $this;
    }
}
