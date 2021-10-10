<?php
declare(strict_types=1);

namespace AMB\Communication\Context;

use Communication\Context\CommunicationContextInterface;
use Symfony\Component\Mime\Address;
use Symfony\Component\Notifier\Message\MessageInterface;

final class ActivityLogContext implements CommunicationContextInterface
{
    private string $formatter;
    private array $bodyContext;

    public function getFormatter()
    {
        return $this->formatter;
    }

    public function setActivityLogFormatter(string $formatter)
    {
        $this->formatter = $formatter;
    }

    public function addBodyContext(string $name, $value): ActivityLogContext
    {
        $this->bodyContext[$name] = $value;

        return $this;
    }

    public function getBodyContext(): array
    {
        return $this->bodyContext;
    }

    public function setBodyContext(array $bodyContext): ActivityLogContext
    {
        $this->bodyContext = $bodyContext;

        return $this;
    }

    public function getFrom(): ?Address
    {
        return null;
    }

    public function setFrom($from)
    {
        // TODO: Implement setFrom() method.
    }

    public function getRecipients(): array
    {
        return [];
    }

    public function setRecipients($recipients)
    {
        // TODO: Implement setRecipients() method.
    }

    public function createMessage(): MessageInterface
    {
        // TODO: Implement createMessage() method.
    }
}
