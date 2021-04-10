<?php
declare(strict_types=1);

namespace AMB\Entity;

use Money\Money;

final class Plan
{
    /** @var \Money\Money */
    private $criticalBalance;
    /** @var string */
    private $group;
    /** @var int */
    private $id;
    /** @var \Money\Money */
    private $minimumBalance;
    /** @var \Money\Money */
    private $price;
    /** @var RenewalFrequency */
    private $renewalFrequency;
    /** @var \Money\Money */
    private $setUpFee;
    /** @var string */
    private $title;

    public function getCriticalBalance(): Money
    {
        return $this->criticalBalance;
    }

    public function setCriticalBalance(Money $criticalBalance): Plan
    {
        $this->criticalBalance = $criticalBalance;

        return $this;
    }

    public function getGroup(): string
    {
        return $this->group;
    }

    public function setGroup(string $group): Plan
    {
        $this->group = $group;

        return $this;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function setId(int $id): Plan
    {
        $this->id = $id;

        return $this;
    }

    public function getMinimumBalance(): Money
    {
        return $this->minimumBalance;
    }

    public function setMinimumBalance(Money $minimumBalance): Plan
    {
        $this->minimumBalance = $minimumBalance;

        return $this;
    }

    public function getPrice(): Money
    {
        return $this->price;
    }

    public function setPrice(Money $price): Plan
    {
        $this->price = $price;

        return $this;
    }

    public function getRenewalFrequency(): RenewalFrequency
    {
        return $this->renewalFrequency;
    }

    public function setRenewalFrequency(RenewalFrequency $renewalFrequency): Plan
    {
        $this->renewalFrequency = $renewalFrequency;

        return $this;
    }

    public function getSetUpFee(): Money
    {
        return $this->setUpFee;
    }

    public function setSetUpFee(Money $setUpFee): Plan
    {
        $this->setUpFee = $setUpFee;

        return $this;
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function setTitle(string $title): Plan
    {
        $this->title = $title;

        return $this;
    }
}
