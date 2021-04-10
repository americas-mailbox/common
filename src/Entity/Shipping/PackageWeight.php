<?php
declare(strict_types=1);

namespace AMB\Entity\Shipping;

final class PackageWeight
{
    /** @var string */
    private $amount;
    /** @var string */
    private $type;
    /** @var string */
    private $unit;

    public function getAmount(): string
    {
        return $this->amount;
    }

    public function setAmount(string $amount): PackageWeight
    {
        $this->amount = $amount;

        return $this;
    }

    public function getWeightInOunces(): float
    {
         if ('oz' === $this->unit) {
             return (float) $this->amount;
         }

         return $this->amount * 16;
    }

    public function getWeightInPounds(): float
    {
         if ('lb' === $this->unit) {
             return (float) $this->amount;
         }

         return (float) ($this->amount / 16);
    }

    public function getType(): string
    {
        return $this->type;
    }

    public function setType(string $type): PackageWeight
    {
        $this->type = $type;

        return $this;
    }

    public function getUnit(): string
    {
        return $this->unit;
    }

    public function setUnit(string $unit): PackageWeight
    {
        $this->unit = strtolower($unit);

        return $this;
    }
}
