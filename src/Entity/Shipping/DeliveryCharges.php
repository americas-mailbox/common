<?php
declare(strict_types=1);

namespace AMB\Entity\Shipping;

use Money\Money;

final class DeliveryCharges
{
    /** @var \Money\Money */
    private $base;
    /** @var \Money\Money */
    private $surcharges;
    /** @var \Money\Money */
    private $total;

    public function getBase(): Money
    {
        return $this->base;
    }

    public function setBase(Money $base): DeliveryCharges
    {
        $this->base = $base;

        return $this;
    }

    public function getSurcharges(): Money
    {
        return $this->surcharges;
    }

    public function setSurcharges(Money $surcharges): DeliveryCharges
    {
        $this->surcharges = $surcharges;

        return $this;
    }

    public function getTotal(): Money
    {
        return $this->total;
    }

    public function setTotal(Money $total): DeliveryCharges
    {
        $this->total = $total;

        return $this;
    }
}
