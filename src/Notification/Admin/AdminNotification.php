<?php
declare(strict_types=1);

namespace AMB\Notification\Admin;

use AMB\Entity\Member;
use AMB\Entity\User;
use AMB\Entity\UserType;
use AMB\Interactor\Notification\NotificationTemplateHandler;
use AMB\Interactor\Notification\GetMemberRecipientChannels;
use AMB\Notification\AmbNotification;
use Notification\Context\NotificationContext;
use Notification\Recipient;
use Notification\RecipientChannels;
use Symfony\Component\Notifier\Notifier;

abstract class AdminNotification extends AmbNotification
{
    public function __construct(
        Notifier $notifier,
        NotificationContext $context,
        NotificationTemplateHandler $emailTemplateHandler,
        array $channels,
        array $communicationFactories
    ) {
        $recipient = (new Recipient())
            ->setEmail("Americas.Mailbox@Gmail.com");

       $recipientChannels = (new RecipientChannels())
            ->addRecipientsToChannel('email', $recipient);
        $this->addRecipientChannel($recipientChannels);

        parent::__construct($notifier, $context, $emailTemplateHandler, $channels, $communicationFactories);
    }
}
