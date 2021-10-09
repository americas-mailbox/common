<?php
declare(strict_types=1);

namespace AMB\Factory\Communication;

use AMB\Interactor\Communication\EmailTemplateHandler;
use Communication\Context\CommunicationContextInterface;
use Communication\Context\EmailContext;
use Communication\Factory\Message\EmailMessageFactory;
use Symfony\Bridge\Twig\Mime\BodyRenderer;
use Symfony\Component\Notifier\Message\EmailMessage;
use Symfony\Component\Notifier\Message\MessageInterface;

final class AmbEmailMessageFactory extends EmailMessageFactory
{
    public function __construct(
        BodyRenderer $renderer,
        private EmailTemplateHandler $templateHandler,
    ) {
        parent::__construct($renderer);
    }

    public function createMessage(
        EmailContext|CommunicationContextInterface $emailContext,
    ): EmailMessage|MessageInterface
    {
        $this->templateHandler->handle($emailContext);

        return parent::createMessage($emailContext);
    }
}
