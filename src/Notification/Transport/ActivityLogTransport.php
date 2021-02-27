<?php
declare(strict_types=1);

namespace AMB\Notification\Transport;

use AMB\Entity\User;
use AMB\Interactor\Log\CreateActivityFromMessage;
use AMB\Interactor\Log\InsertActivity;
use AMB\Interactor\User\ActiveUser;
use AMB\Notification\Message\ActivityLogMessage;
use App\Log\ActivityLog;
use Psr\Log\LogLevel;
use Symfony\Component\Notifier\Message\MessageInterface;
use Symfony\Component\Notifier\Message\SentMessage;
use Symfony\Component\Notifier\Transport\TransportInterface;

final class ActivityLogTransport implements TransportInterface
{
    /** @var \App\Log\ActivityLog */
    private $activityLog;
    /** @var \AMB\Interactor\User\ActiveUser */
    private $activeUser;
    /** @var \AMB\Interactor\Log\CreateActivityFromMessage */
    private $createActivityFromMessage;
    /** @var \AMB\Interactor\Log\InsertActivity */
    private $insertActivity;

    public function __construct(
        ActivityLog $activityLog,
        ActiveUser $activeUser,
        InsertActivity $insertActivity
    ) {
        $this->activityLog = $activityLog;
        $this->activeUser = $activeUser;
        $this->createActivityFromMessage = new CreateActivityFromMessage();
        $this->insertActivity = $insertActivity;
    }

    public function send(MessageInterface $message): ?SentMessage
    {
        $user = $this->activeUser->get();
        $this->log($message, $user);

        return null;
    }

    public function supports(MessageInterface $message): bool
    {
        return is_a($message, ActivityLogMessage::class);
    }

    public function __toString(): string
    {
        return 'ActivityLog';
    }

    private function log(ActivityLogMessage $message, User $actor, $level = LogLevel::INFO)
    {
        $formatter = $message->getFormatter();
        $activityMessage = (new $formatter)($message);

        $activity = $this->createActivityFromMessage->create($message);
        $activity
            ->setActor($actor)
            ->setLevel($level)
            ->setMessage($activityMessage)
            ->setTarget($message->getTarget());

        $this->insertActivity->insert($activity);
    }
}
