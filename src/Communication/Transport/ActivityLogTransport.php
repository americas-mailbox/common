<?php
declare(strict_types=1);

namespace AMB\Communication\Transport;

use AMB\Entity\User;
use AMB\Interactor\Log\CreateActivityFromMessage;
use AMB\Interactor\Log\InsertActivity;
use AMB\Interactor\User\ActiveUser;
use AMB\Communication\Message\ActivityLogMessage;
use Psr\Log\LogLevel;
use Symfony\Component\Notifier\Message\MessageInterface;
use Symfony\Component\Notifier\Message\SentMessage;
use Symfony\Component\Notifier\Transport\TransportInterface;

final class ActivityLogTransport implements TransportInterface
{
    public function __construct(
        private ActiveUser $activeUser,
        private InsertActivity $insertActivity,
    ) {
    }

    public function send(ActivityLogMessage|MessageInterface $message): ?SentMessage
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

        $activity = (new CreateActivityFromMessage())->create($message);
        $activity
            ->setActor($actor)
            ->setLevel($level)
            ->setMessage($activityMessage)
            ->setTarget($message->getTarget());

        $this->insertActivity->insert($activity);
    }
}
