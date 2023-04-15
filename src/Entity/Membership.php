<?php
declare(strict_types=1);

namespace AMB\Entity;

use AMB\Entity\Account\Notifications;
use AMB\Entity\Member\Plan as MemberPlan;
use AMB\Interactor\RapidCityTime;
use Carbon\Carbon;
use IamPersistent\Ledger\Entity\Ledger;

final class Membership
{
    private Account $account;
    private ?string $comment;
    private int $id;
    private ?MemberPlan $memberPlan = null;
    private string|null $pmb = null;
    private Carbon|null $renewDate;
    private ?RapidCityTime $returnToSenderDate = null;
    private string $shippingInstructions = '';
    private Carbon|null $startDate = null;

    public function getAccount(): Account
    {
        return $this->account;
    }

    public function setAccount(Account $account): Member
    {
        $this->account = $account;

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

    public function getId(): int
    {
        return $this->id;
    }

    public function setId(int $id): Member
    {
        $this->id = $id;

        return $this;
    }

    public function getLedger(): Ledger
    {
        return $this->getAccount()->getLedger();
    }

    public function getMemberPlan(): ?MemberPlan
    {
        return $this->memberPlan;
    }

    public function setMemberPlan(?MemberPlan $plan): Member
    {
        $this->memberPlan = $plan;

        return $this;
    }

    public function getMemberStatus(): MemberStatus
    {
        return $this->active;
    }

    public function getNotifications(): Notifications
    {
        return $this->account->getNotifications();
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

    public function getPlan(): ?MemberPlan
    {
        return $this->memberPlan;
    }

    public function setPlan(?MemberPlan $memberPlan): Member
    {
        $this->memberPlan = $memberPlan;

        return $this;
    }

    public function getPMB(): string|null
    {
        return $this->pmb;
    }

    public function setPMB(string|null $pmb): Member
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

    public function getReturnToSenderDate(): ?RapidCityTime
    {
        return $this->returnToSenderDate;
    }

    public function setReturnToSenderDate(?RapidCityTime $returnToSenderDate): Member
    {
        $this->returnToSenderDate = $returnToSenderDate;

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

    public function getStartDate(): Carbon
    {
        return $this->startDate;
    }

    public function setStartDate(Carbon $startDate): Member
    {
        $this->startDate = $startDate;

        return $this;
    }

    public function getStatus(): string
    {
        if ($this->suspended) {
            return 'Suspended';
        }

        return ucfirst(strtolower($this->active->getKey()));
    }

    public function useNewDashboard(): bool
    {
        return $this->useNewDashboard;
    }

    public function setUseNewDashboard(bool $useNewDashboard): Member
    {
        $this->useNewDashboard = $useNewDashboard;

        return $this;
    }
}
