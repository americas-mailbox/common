<?php
declare(strict_types=1);

namespace AMB\Factory\Communication;

use AMB\Interactor\Communication\EmailTemplateHandler;
use Communication\Context\CommunicationContextInterface;
use Communication\Context\EmailContext;
use Communication\Factory\Message\MessageFactoryInterface;
use Symfony\Bridge\Twig\Mime\BodyRenderer;
use Symfony\Component\Notifier\Message\EmailMessage;
use Symfony\Component\Notifier\Message\MessageInterface;

final class AmbActivityLogMessageFactory implements MessageFactoryInterface
{
    public function __construct(
        BodyRenderer $renderer,
        private EmailTemplateHandler $templateHandler,
    ) {
        parent::__construct($renderer);
    }

    public function createMessage(
        EmailContext|CommunicationContextInterface $logContext,
    ): EmailMessage|MessageInterface
    {
        $this->templateHandler->handle($emailContext);

        return parent::createMessage($emailContext);
    }
}
