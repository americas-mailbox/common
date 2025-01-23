<?php
declare(strict_types=1);

namespace AMB\Entity;

use AMB\Entity\Account\Notifications;
use Carbon\Carbon;
use IamPersistent\Ledger\Entity\Ledger;
use OLPS\SimpleShop\Entity\CreditCard;
use Money\Money;

class Account
{
    /** @var bool */
    private $autoRenew;
    /** @var bool */
    private $autoTopUp;
    /** @var Money */
    private $criticalBalance;
    /** @var bool */
    private $customAutoTopUp;
    /** @var bool */
    private $customCriticalBalance;
    /** @var bool */
    private $customMinimumAllowedBalance;
    /** @var CreditCard */
    private $defaultCard;
    /** @var int */
    private $id;
    /** @var Ledger */
    private $ledger;
    /** @var Money */
    private $minimumAllowedBalance;
    private Notifications $notifications;
    /** @var string */
    private $officeClosedDeliveryPreference;
    /** @var \Carbon\Carbon */
    private $renewalDate;
    /** @var \Carbon\Carbon */
    private $startDate;
    /** @var Money */
    private $subscriptionPrice;
    /** @var Money */
    private $topUpAmount;

    public function isAutoRenew(): bool
    {
        return $this->autoRenew;
    }

    public function setAutoRenew(bool $autoRenew): Account
    {
        $this->autoRenew = $autoRenew;

        return $this;
    }

    public function isAutoTopUp(): bool
    {
        return $this->autoTopUp;
    }

    public function setAutoTopUp(bool $autoTopUp): Account
    {
        $this->autoTopUp = $autoTopUp;

        return $this;
    }

    public function getCriticalBalance(): Money
    {
        return $this->criticalBalance;
    }

    public function setCriticalBalance(Money $criticalBalance): Account
    {
        $this->criticalBalance = $criticalBalance;

        return $this;
    }

    public function isCustomAutoTopUp(): bool
    {
        return $this->customAutoTopUp;
    }

    public function setCustomAutoTopUp(bool $customAutoTopUp): Account
    {
        $this->customAutoTopUp = $customAutoTopUp;

        return $this;
    }

    public function isCustomCriticalBalance(): bool
    {
        return $this->customCriticalBalance;
    }

    public function setCustomCriticalBalance(bool $customCriticalBalance): Account
    {
        $this->customCriticalBalance = $customCriticalBalance;

        return $this;
    }

    public function isCustomMinimumAllowedBalance(): bool
    {
        return $this->customMinimumAllowedBalance;
    }

    public function setCustomMinimumAllowedBalance(bool $customMinimumAllowedBalance): Account
    {
        $this->customMinimumAllowedBalance = $customMinimumAllowedBalance;

        return $this;
    }

    public function getDefaultCard(): ?CreditCard
    {
        return $this->defaultCard;
    }

    public function setDefaultCard(CreditCard $defaultCard): Account
    {
        $this->defaultCard = $defaultCard;

        return $this;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function setId(int $id): Account
    {
        $this->id = $id;

        return $this;
    }

    public function getLedger(): Ledger
    {
        return $this->ledger;
    }

    public function setLedger(Ledger $ledger): Account
    {
        $this->ledger = $ledger;

        return $this;
    }

    public function getMinimumAllowedBalance(): Money
    {
        return $this->minimumAllowedBalance;
    }

    public function setMinimumAllowedBalance(Money $minimumAllowedBalance): Account
    {
        $this->minimumAllowedBalance = $minimumAllowedBalance;

        return $this;
    }

    public function getNotifications(): Account\Notifications
    {
        return $this->notifications;
    }

    public function setNotifications(Account\Notifications $notifications): Account
    {
        $this->notifications = $notifications;

        return $this;
    }

    public function getOfficeClosedDeliveryPreference(): string
    {
        return $this->officeClosedDeliveryPreference;
    }

    public function setOfficeClosedDeliveryPreference(string $officeClosedDeliveryPreference): Account
    {
        $this->officeClosedDeliveryPreference = $officeClosedDeliveryPreference;

        return $this;
    }

    public function getRenewalDate(): Carbon
    {
        return $this->renewalDate;
    }

    public function setRenewalDate(Carbon $renewalDate): Account
    {
        $this->renewalDate = $renewalDate;

        return $this;
    }

    public function getStartDate(): Carbon
    {
        return $this->startDate;
    }

    public function setStartDate(Carbon $startDate): Account
    {
        $this->startDate = $startDate;

        return $this;
    }

    public function getSubscriptionPrice(): Money
    {
        return $this->subscriptionPrice;
    }

    public function setSubscriptionPrice(Money $subscriptionPrice): Account
    {
        $this->subscriptionPrice = $subscriptionPrice;

        return $this;
    }

    public function getTopUpAmount(): Money
    {
        return $this->topUpAmount;
    }

    public function setTopUpAmount(Money $topUpAmount): Account
    {
        $this->topUpAmount = $topUpAmount;

        return $this;
    }
}
