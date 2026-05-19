<?php
declare(strict_types=1);

namespace AMB\Notification\Channel;

use AMB\Notification\Communication\ActivityLogNotification;
use AMB\Notification\Transport\ActivityLogTransport;
use Symfony\Component\Notifier\Channel\ChannelInterface;
use Symfony\Component\Notifier\Notification\Notification;
use Symfony\Component\Notifier\Recipient\RecipientInterface;

final readonly class ActivityLogChannel implements ChannelInterface
{
    public function __construct(private ActivityLogTransport $transport)
    {
    }

    public function notify(
        Notification $notification,
        RecipientInterface $recipient,
        ?string $transportName = null
    ): void {
        $this->transport->send($notification->getMessage());
    }

    public function supports(Notification $notification, RecipientInterface $recipient): bool
    {
        return is_a($notification, ActivityLogNotification::class);
    }
}
