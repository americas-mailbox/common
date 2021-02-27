<?php
declare(strict_types=1);

namespace AMB\Notification;

use AMB\Interactor\Notification\NotificationTemplateHandler;
use AMB\Notification\Context\ActivityLogContext;
use Notification\Context\NotificationContext;
use Notification\Notification;
use Notification\RecipientChannels;
use Symfony\Component\Notifier\Notifier;
use Symfony\Component\Notifier\Recipient\NoRecipient;

abstract class AmbNotification extends Notification
{
    /** @var \AMB\Interactor\Notification\NotificationTemplateHandler */
    private $templateHandler;

    public function __construct(
        Notifier $notifier,
        NotificationContext $context,
        NotificationTemplateHandler $templateHandler,
        array $channels,
        array $communicationFactories
    ) {
        $this->templateHandler = $templateHandler;

        parent::__construct($notifier, $context, $channels, $communicationFactories);
    }

    public function send()
    {
        $template = $this->context->getMeta('email')->getHtmlTemplate();
        $this->templateHandler->handle($template, $this->context);

        parent::send();
    }

    public function logActivity(string $formatter): self
    {
        $recipientChannel = (new RecipientChannels())
            ->addRecipientsToChannel('log', new NoRecipient());
        $this->addRecipientChannel($recipientChannel);

        $context = (new ActivityLogContext())
            ->setFormatter($formatter);
        $this->context->setMeta('log', $context);

        return $this;
    }
}
