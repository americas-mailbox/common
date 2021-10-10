<?php
declare(strict_types=1);

namespace AMB\Communication\Message;

use AMB\Entity\User;
use AMB\Communication\Context\ActivityLogContext;
use App\MemberMessage;
use Exception;
use Symfony\Component\Notifier\Message\MessageInterface;
use Symfony\Component\Notifier\Message\MessageOptionsInterface;

final class ActivityLogMessage extends MemberMessage implements MessageInterface
{
    public function __construct(
        private ActivityLogContext $context,
        private array $data,
    ) {
        parent::__construct();
    }

    public function __call(string $name, array $arguments)
    {
        $action = substr($name, 0,3);
        if ($action !== 'get' && $action !== 'set') {
            throw new Exception("Unknown method \"$name\"");
        }
        $key = lcfirst(substr($name, 3));
        if ($action === 'set') {
            $this->data[$key] = $arguments[0];

            return;
        }
        if (!isset($this->data[$key])) {
            throw new Exception("Missing property \"$key\"");
        }

        return $this->data[$key];
    }

    public function getPmb(): ?string
    {
        return $this->data['pmb'];
    }

    public function getFormatter()
    {
        return $this->context->getFormatter();
    }

    public function getRecipientId(): ?string
    {
        return null;
    }

    public function getSubject(): string
    {
        return '';
    }

    public function getTarget(): ?User
    {
        return $this->data['target'] ?? null;
    }

    public function getOptions(): ?MessageOptionsInterface
    {
        return null;
    }

    public function getTransport(): ?string
    {
        // TODO: Implement getTransport() method.
    }
}
