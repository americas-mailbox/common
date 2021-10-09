<?php
declare(strict_types=1);

namespace AMB\Communication;

use AMB\Entity\Member;
use AMB\Entity\User;
use AMB\Entity\UserType;

abstract class MemberCommunication extends AmbCommunication
{
    protected User $target;

    public function getMemberId(): int
    {
        return $this->target->getId();
    }

    public function setValuesFromMember(Member $member): self
    {
        $user = (new User())
            ->setId($member->getId())
            ->setPmb($member->getPMB())
            ->setType(new UserType('member'));
        $this->target = $user;
        $this->context
            ->set('fullName', $member->getFullName())
            ->set('pmb', $member->getPMB())
            ->set('target', $user);
        $this->setRecipientChannels([$this->getChannels->getRecipientChannels($member)]);

        return $this;
    }

    protected function getAllowedChannels(): array
    {
        return [
            'email',
        ];
    }
}
