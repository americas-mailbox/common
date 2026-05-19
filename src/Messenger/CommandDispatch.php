<?php
declare(strict_types=1);

namespace AMB\Messenger;

use App\Log\ActivityLog;
use AMB\Interactor\User\ActiveUser;
use Symfony\Component\Messenger\Envelope;
use Symfony\Component\Messenger\MessageBus;

final class CommandDispatch
{
    /** @var ActiveUser */
    private $activeUser;
    /** @var ActivityLog */
    private $activityLog;

    public function __construct(private readonly MessageBus $commandBus, ActivityLog $activityLog, ActiveUser $activeUser)
    {
        $this->activeUser = $activeUser;
        $this->activityLog = $activityLog;
    }

    public function dispatch($message): Envelope
    {
        $user = $this->activeUser->get();
        $this->activityLog->log($message, $user);
        $stamps = [(new UserStamp($user))];
        $envelope = (new Envelope($message, $stamps));

        return $this->commandBus->dispatch($envelope);
    }
}
