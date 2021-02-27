<?php
declare(strict_types=1);

namespace AMB\Notification\Member;

use AMB\Entity\Member;
use AMB\Entity\User;
use AMB\Entity\UserType;
use AMB\Interactor\Notification\NotificationTemplateHandler;
use AMB\Interactor\Notification\GetMemberRecipientChannels;
use AMB\Notification\AmbNotification;
use Notification\Context\NotificationContext;
use Symfony\Component\Notifier\Notifier;

abstract class MemberNotification extends AmbNotification
{
    /** @var \AMB\Interactor\Notification\GetMemberRecipientChannels */
    protected $getChannels;
    /** @var \AMB\Entity\User */
    protected $target;

    public function __construct(
        Notifier $notifier,
        NotificationContext $context,
        NotificationTemplateHandler $emailTemplateHandler,
        GetMemberRecipientChannels $getMemberRecipientChannels,
        array $channels,
        array $communicationFactories
    ) {
        $this->getChannels = $getMemberRecipientChannels;

        parent::__construct($notifier, $context, $emailTemplateHandler, $channels, $communicationFactories);
    }

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
        $this->addRecipientChannel($this->getChannels->getRecipientChannels($member));

        return $this;
    }
}
