<?php
declare(strict_types=1);

namespace AMB\Communication\Factory;

use AMB\Communication\Context\ActivityLogContext;
use AMB\Communication\Message\ActivityLogMessage;
use AMB\Communication\Notification\ActivityLogNotification;
use Communication\Context\CommunicationContextInterface;
use Communication\Factory\Notification\NotificationFactoryInterface;
use Symfony\Component\Notifier\Notification\Notification;

final class ActivityLogNotificationFactory implements NotificationFactoryInterface
{
    public function create(ActivityLogContext|CommunicationContextInterface $context, string $channel): Notification
    {
        $message = $this->createMessage($context);

        return new ActivityLogNotification($message, $message->getSubject(), ['log']);
    }

    private function createMessage(ActivityLogContext $context): ActivityLogMessage
    {
        return new ActivityLogMessage($context, $context->getBodyContext());
    }
}
