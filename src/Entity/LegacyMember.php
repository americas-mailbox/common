<?php
declare(strict_types=1);

namespace AMB\Entity;

use AMB\Entity\Account\Notifications;
use AMB\Entity\Member\Plan as MemberPlan;
use AMB\Interactor\RapidCityTime;
use Carbon\Carbon;
use Communication\Recipient;
use IamPersistent\Ledger\Entity\Ledger;
use Zestic\Contracts\User\UserInterface;

final class LegacyMember implements UserInterface
{
    private Account $account;
    /** @var LegacyMemberStatus */
    private $active;
    /** @var string|null */
    private $alternateEmail;
    /** @var string|null */
    private $alternateName;
    /** @var string|null */
    private $alternatePhone;
    private ?string $comment;
    private ?Recipient $communicationRecipient = null;
    private string $email = '';
    /** @var string */
    private $firstName;
    /** @var int */
    private $id;
    /** @var string */
    private $lastName;
    /** @var string|null */
    private $middleName;
    private ?MemberPlan $memberPlan = null;
    /** @var string */
    private $phone;
    private string|null $pmb = null;
    /** @var string|null */
    private $pin = null;
    /** @var Carbon|null */
    private $renewDate;
    private ?RapidCityTime $returnToSenderDate = null;
    /** @var string|null */
    private $shippingInstructions;
    /** @var Carbon|null */
    private $startDate;
    /** @var string|null */
    private $suffix;
    /** @var bool */
    private $suspended;
    private bool $useNewDashboard = false;

    public function getAccount(): Account
    {
        return $this->account;
    }

    public function setAccount(Account $account): LegacyMember
    {
        $this->account = $account;

        return $this;
    }

    public function getActive(): LegacyMemberStatus
    {
        return $this->active;
    }

    public function setActive(LegacyMemberStatus $active): LegacyMember
    {
        $this->active = $active;

        return $this;
    }

    public function getAlternateEmail(): ?string
    {
        return $this->alternateEmail;
    }

    public function setAlternateEmail(?string $alternateEmail): LegacyMember
    {
        $this->alternateEmail = $alternateEmail;

        return $this;
    }

    public function getAlternateName(): ?string
    {
        return $this->alternateName;
    }

    public function setAlternateName(?string $alternateName): LegacyMember
    {
        $this->alternateName = $alternateName;

        return $this;
    }

    public function getAlternatePhone(): ?string
    {
        return $this->alternatePhone;
    }

    public function setAlternatePhone(?string $alternatePhone): LegacyMember
    {
        $this->alternatePhone = $alternatePhone;

        return $this;
    }

    public function getComment(): string
    {
        return (string) $this->comment;
    }

    public function setComment(?string $comment): LegacyMember
    {
        $this->comment = $comment;

        return $this;
    }

    public function getCommunicationRecipient(): Recipient
    {
        if (!$this->communicationRecipient) {
            $this->communicationRecipient = (new Recipient())
                ->setEmail((string) $this->email)
                ->setName($this->getFullName())
                ->setPhone((string) $this->phone);
        }

        return $this->communicationRecipient;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): LegacyMember
    {
        $this->email = $email;

        return $this;
    }

    public function getFirstName(): string
    {
        return $this->firstName;
    }

    public function setFirstName(string $firstName): LegacyMember
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

    public function setId(int $id): LegacyMember
    {
        $this->id = $id;

        return $this;
    }

    public function getLastName(): string
    {
        return $this->lastName;
    }

    public function setLastName(string $lastName): LegacyMember
    {
        $this->lastName = $lastName;

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

    public function setMemberPlan(?MemberPlan $plan): LegacyMember
    {
        $this->memberPlan = $plan;

        return $this;
    }

    public function getMemberStatus(): LegacyMemberStatus
    {
        return $this->active;
    }

    public function getMiddleName(): string
    {
        return (string) $this->middleName;
    }

    public function setMiddleName(?string $middleName): LegacyMember
    {
        $this->middleName = $middleName;

        return $this;
    }

    public function getNotifications(): Notifications
    {
        return $this->account->getNotifications();
    }

    public function getPIN(): ?string
    {
        return $this->pin;
    }

    public function setPIN(?string $pin): LegacyMember
    {
        $this->pin = $pin;

        return $this;
    }

    public function getPhone(): string
    {
        return $this->phone;
    }

    public function setPhone(string $phone): LegacyMember
    {
        $this->phone = $phone;

        return $this;
    }

    public function getPlan(): ?MemberPlan
    {
        return $this->memberPlan;
    }

    public function setPlan(?MemberPlan $memberPlan): LegacyMember
    {
        $this->memberPlan = $memberPlan;

        return $this;
    }

    public function getPMB(): string|null
    {
        return $this->pmb;
    }

    public function setPMB(string|null $pmb): LegacyMember
    {
        $this->pmb = $pmb;

        return $this;
    }

    public function getRenewDate(): ?Carbon
    {
        return $this->renewDate;
    }

    public function setRenewDate(?Carbon $renewDate): LegacyMember
    {
        $this->renewDate = $renewDate;

        return $this;
    }

    public function getReturnToSenderDate(): ?RapidCityTime
    {
        return $this->returnToSenderDate;
    }

    public function setReturnToSenderDate(?RapidCityTime $returnToSenderDate): LegacyMember
    {
        $this->returnToSenderDate = $returnToSenderDate;

        return $this;
    }

    public function getShippingInstructions(): string
    {
        return (string) $this->shippingInstructions;
    }

    public function setShippingInstructions(?string $shippingInstructions): LegacyMember
    {
        $this->shippingInstructions = $shippingInstructions;

        return $this;
    }

    public function getStartDate(): Carbon
    {
        return $this->startDate;
    }

    public function setStartDate(Carbon $startDate): LegacyMember
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

    public function getSuffix(): string
    {
        return (string) $this->suffix;
    }

    public function setSuffix(?string $suffix): LegacyMember
    {
        $this->suffix = $suffix;

        return $this;
    }

    public function isSuspended(): bool
    {
        return $this->suspended;
    }

    public function setSuspended(bool $suspended): LegacyMember
    {
        $this->suspended = $suspended;

        return $this;
    }

    public function useNewDashboard(): bool
    {
        return $this->useNewDashboard;
    }

    public function setUseNewDashboard(bool $useNewDashboard): LegacyMember
    {
        $this->useNewDashboard = $useNewDashboard;

        return $this;
    }
}
