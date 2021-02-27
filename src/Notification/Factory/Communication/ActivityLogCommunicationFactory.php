<?php
declare(strict_types=1);

namespace AMB\Notification\Factory\Communication;

use AMB\Notification\Communication\ActivityLogCommunication;
use AMB\Notification\Message\ActivityLogMessage;
use Notification\Context\NotificationContext;
use Notification\Factory\Communication\CommunicationFactoryInterface;
use Symfony\Component\Notifier\Notification\Notification as Communication;

final class ActivityLogCommunicationFactory implements CommunicationFactoryInterface
{
    public function create(NotificationContext $context, string $channel): Communication
    {
        $message = $this->createMessage($context);

        return new ActivityLogCommunication($message, (string) $context->get('subject'), ['log']);
    }

    private function createMessage(NotificationContext $context): ActivityLogMessage
    {
        return new ActivityLogMessage($context->getMeta('log'), $context->toArray());
    }
}
