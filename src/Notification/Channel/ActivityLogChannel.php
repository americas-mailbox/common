<?php
declare(strict_types=1);

namespace AMB\Notification\Channel;

use AMB\Notification\Communication\ActivityLogCommunication;
use AMB\Notification\Transport\ActivityLogTransport;
use Symfony\Component\Notifier\Channel\ChannelInterface;
use Symfony\Component\Notifier\Notification\Notification;
use Symfony\Component\Notifier\Recipient\RecipientInterface;

final class ActivityLogChannel implements ChannelInterface
{
    /** @var \AMB\Notification\Transport\ActivityLogTransport */
    private $transport;

    public function __construct(
        ActivityLogTransport $transport
    ) {
        $this->transport = $transport;
    }

    public function notify(
        Notification $notification,
        RecipientInterface $recipient,
        string $transportName = null
    ): void {
        $this->transport->send($notification->getMessage());
    }

    public function supports(Notification $notification, RecipientInterface $recipient): bool
    {
        return is_a($notification, ActivityLogCommunication::class);
    }
}
