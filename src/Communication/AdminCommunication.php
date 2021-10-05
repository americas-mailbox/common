<?php
declare(strict_types=1);

namespace AMB\Communication;

use AMB\Interactor\Communication\CommunicationTemplateHandler;
use Communication\Context\CommunicationContext;
use Communication\Recipient;
use Communication\RecipientChannels;
use Symfony\Component\Notifier\Notifier;

abstract class AdminCommunication extends AmbCommunication
{
    public function __construct(
        Notifier $notifier,
        CommunicationContext $context,
        CommunicationTemplateHandler $emailTemplateHandler,
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

    protected function getTemplates(): array
    {
        return [
            'email' => [
                'html' => 'generic'
            ],
        ];
    }
}
