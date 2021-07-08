<?php
declare(strict_types=1);

namespace AMB\Entity;

use AMB\Entity\Member\Plan;
use Carbon\Carbon;
use IamPersistent\Ledger\Entity\Ledger;

final class Member
{
    /** @var Account */
    private $account;
    /** @var MemberStatus */
    private $active;
    /** @var string|null */
    private $alternateEmail;
    /** @var string|null */
    private $alternateName;
    /** @var string|null */
    private $alternatePhone;
    /** @var string|null */
    private $comment;
    /** @var string */
    private $email;
    /** @var string */
    private $firstName;
    /** @var int */
    private $id;
    /** @var string */
    private $lastName;
    /** @var Carbon|null */
    private $lowBalanceDateNotified;
    /** @var string|null */
    private $middleName;
    /** @var \AMB\Entity\Member\Plan */
    private $plan;
    /** @var string */
    private $phone;
    /** @var string|null */
    private $pmb;
    /** @var string|null */
    private $pin;
    /** @var Carbon|null */
    private $renewDate;
    /** @var string|null */
    private $shippingInstructions;
    /** @var Carbon|null */
    private $startDate;
    /** @var string|null */
    private $suffix;
    /** @var bool */
    private $suspended;
    /** @var int */
    private $totalLowBalanceNotifications;

    public function getAccount(): Account
    {
        return $this->account;
    }

    public function setAccount(Account $account): Member
    {
        $this->account = $account;

        return $this;
    }

    public function getActive(): MemberStatus
    {
        return $this->active;
    }

    public function setActive(MemberStatus $active): Member
    {
        $this->active = $active;

        return $this;
    }

    public function getAlternateEmail(): ?string
    {
        return $this->alternateEmail;
    }

    public function setAlternateEmail(?string $alternateEmail): Member
    {
        $this->alternateEmail = $alternateEmail;

        return $this;
    }

    public function getAlternateName(): ?string
    {
        return $this->alternateName;
    }

    public function setAlternateName(?string $alternateName): Member
    {
        $this->alternateName = $alternateName;

        return $this;
    }

    public function getAlternatePhone(): ?string
    {
        return $this->alternatePhone;
    }

    public function setAlternatePhone(?string $alternatePhone): Member
    {
        $this->alternatePhone = $alternatePhone;

        return $this;
    }

    public function getComment(): string
    {
        return (string) $this->comment;
    }

    public function setComment(?string $comment): Member
    {
        $this->comment = $comment;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): Member
    {
        $this->email = $email;

        return $this;
    }

    public function getFirstName(): string
    {
        return $this->firstName;
    }

    public function setFirstName(string $firstName): Member
    {
        $this->firstName = $firstName;

        return $this;
    }

    public function getFullName(): string
    {
        $parts = [];
        if ($this->firstName) {
            $parts[] = $this->firstName;
        }
        if ($this->lastName) {
            $parts[] = $this->lastName;
        }

        return implode(' ', $parts);
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function setId(int $id): Member
    {
        $this->id = $id;

        return $this;
    }

    public function getLastName(): string
    {
        return $this->lastName;
    }

    public function setLastName(string $lastName): Member
    {
        $this->lastName = $lastName;

        return $this;
    }

    public function getLedger(): Ledger
    {
        return $this->getAccount()->getLedger();
    }

    public function getLowBalanceDateNotified(): ?Carbon
    {
        return $this->lowBalanceDateNotified;
    }

    public function setLowBalanceDateNotified(?Carbon $lowBalanceDateNotified): Member
    {
        $this->lowBalanceDateNotified = $lowBalanceDateNotified;

        return $this;
    }

    public function getMiddleName(): string
    {
        return (string) $this->middleName;
    }

    public function setMiddleName(?string $middleName): Member
    {
        $this->middleName = $middleName;

        return $this;
    }

    public function getPIN(): ?string
    {
        return $this->pin;
    }

    public function setPIN(?string $pin): Member
    {
        $this->pin = $pin;

        return $this;
    }

    public function getPhone(): string
    {
        return $this->phone;
    }

    public function setPhone(string $phone): Member
    {
        $this->phone = $phone;

        return $this;
    }

    public function getPlan(): ?Plan
    {
        return $this->plan;
    }

    public function setPlan(?Plan $plan): Member
    {
        $this->plan = $plan;

        return $this;
    }

    public function getPMB(): ?string
    {
        return $this->pmb;
    }

    public function setPMB(?string $pmb): Member
    {
        $this->pmb = $pmb;

        return $this;
    }

    public function getRenewDate(): ?Carbon
    {
        return $this->renewDate;
    }

    public function setRenewDate(?Carbon $renewDate): Member
    {
        $this->renewDate = $renewDate;

        return $this;
    }

    public function getShippingInstructions(): string
    {
        return (string) $this->shippingInstructions;
    }

    public function setShippingInstructions(?string $shippingInstructions): Member
    {
        $this->shippingInstructions = $shippingInstructions;

        return $this;
    }

    public function getStartDate(): ?Carbon
    {
        return $this->startDate;
    }

    public function setStartDate(Carbon $startDate): Member
    {
        $this->startDate = $startDate;

        return $this;
    }

    public function getSuffix(): string
    {
        return (string) $this->suffix;
    }

    public function setSuffix(?string $suffix): Member
    {
        $this->suffix = $suffix;

        return $this;
    }

    public function isSuspended(): bool
    {
        return $this->suspended;
    }

    public function setSuspended(bool $suspended): Member
    {
        $this->suspended = $suspended;

        return $this;
    }

    public function getTotalLowBalanceNotifications(): int
    {
        return $this->totalLowBalanceNotifications;
    }

    public function setTotalLowBalanceNotifications(int $totalLowBalanceNotifications): Member
    {
        $this->totalLowBalanceNotifications = $totalLowBalanceNotifications;

        return $this;
    }
}