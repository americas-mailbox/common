<?php
declare(strict_types=1);

namespace AMB\Messenger;

use Symfony\Component\Messenger\Envelope;
use Symfony\Component\Messenger\MessageBus;

final class EventDispatch
{
    /** @var MessageBus */
    private $eventBus;

    public function __construct(MessageBus $eventBus)
    {
        $this->eventBus = $eventBus;
    }

    public function dispatch($message): Envelope
    {
        return $this->eventBus->dispatch($message);
    }
}
