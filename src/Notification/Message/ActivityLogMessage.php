<?php
declare(strict_types=1);

namespace AMB\Notification\Message;

use AMB\Entity\User;
use AMB\Notification\Context\ActivityLogContext;
use App\MemberMessage;
use Symfony\Component\Notifier\Message\MessageInterface;
use Symfony\Component\Notifier\Message\MessageOptionsInterface;

final class ActivityLogMessage extends MemberMessage implements MessageInterface
{
    /** @var \AMB\Notification\Context\ActivityLogContext */
    private $context;
    /** @var array */
    private $data;

    public function __construct(
        ActivityLogContext $context,
        array $data
    ) {
        $this->context = $context;
        $this->data = $data;

        parent::__construct();
    }

    public function __call(string $name, array $arguments)
    {
        if (0 !== strpos( $name , 'get' )) {
            throw new \Exception("Unknown method \"$name\"");
        }

        $key = lcfirst(substr($name, 3));
        if (!isset($this->data[$key])) {
            throw new \Exception("Missing property \"$key\"");
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
