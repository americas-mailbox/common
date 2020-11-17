<?php
declare(strict_types=1);

namespace AMB\Messenger;

use AMB\Entity\Member;
use AMB\Entity\User;
use AMB\Entity\UserType;
use AMB\Interactor\Notify\GetPartyContext;

trait MemberMessageTrait
{
    /** @var string */
    protected $fullName;
    /** @var string */
    protected $pmb;

    public function getFullName(): string
    {
        return $this->fullName;
    }

    public function getMemberId(): int
    {
        return $this->target->getId();
    }

    public function getPmb(): ?string
    {
        return $this->pmb;
    }

    public function setValuesFromMember(Member $member)
    {
        $pmb = $member->getPMB();
        $user = (new User())
            ->setId($member->getId())
            ->setPmb($pmb)
            ->setType(new UserType('member'));
        $this->fullName = $member->getFullName();
        $this->pmb = $pmb;
        $this->sendTo = (new GetPartyContext)->fromMember($member);
        $this->target = $user;

        return $this;
    }
}
