<?php
declare(strict_types=1);

namespace AMB\Messenger;

use Symfony\Component\Messenger\Envelope;
use Symfony\Component\Messenger\MessageBus;

final readonly class EventDispatch
{
    public function __construct(private MessageBus $eventBus)
    {
    }

    public function dispatch($message): Envelope
    {
        return $this->eventBus->dispatch($message);
    }
}
