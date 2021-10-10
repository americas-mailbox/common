<?php
declare(strict_types=1);

namespace AMB\Communication\Notification;

use AMB\Communication\Message\ActivityLogMessage;
use Symfony\Component\Notifier\Notification\Notification;

final class ActivityLogNotification extends Notification
{
    public function __construct(
        protected ActivityLogMessage $message,
        string $subject = '',
        array $channels = []
    ) {
        parent::__construct($subject, $channels);
    }

    public function getMessage(): ActivityLogMessage
    {
        return $this->message;
    }
}
