<?php
declare(strict_types=1);

namespace AMB\Messenger;

use AMB\App\Log\ActivityLog;
use AMB\App\Message;
use AMB\Interactor\User\ActiveUser;
use Symfony\Component\Messenger\Envelope;
use Symfony\Component\Messenger\MessageBus;

final class LoggedEventDispatch
{
    /** @var ActiveUser */
    private $activeUser;
    /** @var ActivityLog */
    private $activityLog;
    /** @var MessageBus */
    private $eventBus;

    public function __construct(MessageBus $eventBus, ActivityLog $activityLog, ActiveUser $activeUser)
    {
        $this->activeUser = $activeUser;
        $this->activityLog = $activityLog;
        $this->eventBus = $eventBus;
    }

    public function dispatch(Message $message): Envelope
    {
        $user = $this->activeUser->get();
        $this->activityLog->log($message, $user);
        $stamps = [(new UserStamp($user))];
        $envelope = (new Envelope($message, $stamps));

        return $this->eventBus->dispatch($envelope);
    }
}
