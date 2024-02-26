<?php
declare(strict_types=1);

namespace AMB\Entity\Shipping;

final class Delivery
{
    /** @var \AMB\Entity\Shipping\Carrier */
    private $carrier;
    /** @var DeliveryCharges */
    private $charges;
    /** @var mixed */
    private $id = null;
    /** @var string|null */
    private $packageCode;
    /** @var \AMB\Entity\Shipping\PackageSize|null */
    private $packageSize;
    /** @var PackageWeight */
    private $packageWeight;
    /** @var string */
    private $serviceCode;
    /** @var string */
    private $trackingNumber;
    /** @var string|null */
    private $zone;

    public function getCarrier(): Carrier
    {
        return $this->carrier;
    }

    public function setCarrier(Carrier $carrier): Delivery
    {
        $this->carrier = $carrier;

        return $this;
    }

    public function getCharges(): DeliveryCharges
    {
        return $this->charges;
    }

    public function setCharges(DeliveryCharges $charges): Delivery
    {
        $this->charges = $charges;

        return $this;
    }

    public function getId()
    {
        return $this->id;
    }

    public function setId($id): Delivery
    {
        $this->id = $id;

        return $this;
    }

    public function getPackageCode(): ?string
    {
        return $this->packageCode;
    }

    public function setPackageCode(?string $packageCode): Delivery
    {
        $this->packageCode = $packageCode;

        return $this;
    }

    public function getPackageSize(): ?PackageSize
    {
        return $this->packageSize;
    }

    public function setPackageSize(?PackageSize $packageSize): Delivery
    {
        $this->packageSize = $packageSize;

        return $this;
    }

    public function getPackageWeight(): PackageWeight
    {
        return $this->packageWeight;
    }

    public function setPackageWeight(PackageWeight $packageWeight): Delivery
    {
        $this->packageWeight = $packageWeight;

        return $this;
    }

    public function getServiceCode(): string
    {
        return $this->serviceCode;
    }

    public function setServiceCode(string $serviceCode): Delivery
    {
        $this->serviceCode = $serviceCode;

        return $this;
    }

    public function getTrackingNumber(): string
    {
        return $this->trackingNumber;
    }

    public function setTrackingNumber(string $trackingNumber): Delivery
    {
        $this->trackingNumber = $trackingNumber;

        return $this;
    }

    public function getZone(): ?string
    {
        return $this->zone;
    }

    public function setZone(?string $zone): Delivery
    {
        $this->zone = $zone;

        return $this;
    }
}
