<?php
declare(strict_types=1);

namespace AMB\Messenger;

use App\Log\ActivityLog;
use App\Message;
use AMB\Interactor\User\ActiveUser;
use Symfony\Component\Messenger\Envelope;
use Symfony\Component\Messenger\MessageBus;

final class LoggedEventDispatch
{
    /** @var ActiveUser */
    private $activeUser;
    /** @var ActivityLog */
    private $activityLog;

    public function __construct(private readonly MessageBus $eventBus, ActivityLog $activityLog, ActiveUser $activeUser)
    {
        $this->activeUser = $activeUser;
        $this->activityLog = $activityLog;
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
