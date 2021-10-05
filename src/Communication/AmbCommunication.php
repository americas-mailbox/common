<?php
declare(strict_types=1);

namespace AMB\Communication;

use AMB\Interactor\Communication\CommunicationTemplateHandler;
use AMB\Notification\Context\ActivityLogContext;
use Communication\Context\CommunicationContext;
use Communication\Communication;
use Symfony\Component\Notifier\NotifierInterface;
use Symfony\Component\Notifier\Recipient\NoRecipient;

abstract class AmbCommunication extends Communication
{
    public function __construct(
        protected CommunicationTemplateHandler $templateHandler,
        CommunicationContext $context,
        array $notificationFactories,
        NotifierInterface $notifier,
    ) {
        parent::__construct($context, $notificationFactories, $notifier);
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
