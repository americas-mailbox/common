<?php
declare(strict_types=1);

namespace AMB\Notification\Communication;

use AMB\Notification\Message\ActivityLogMessage;
use Symfony\Component\Notifier\Notification\Notification as Communication;

final class ActivityLogCommunication extends Communication
{
    protected $message;

    public function __construct(
        ActivityLogMessage $message,
        string $subject = '',
        array $channels = []
    ) {
        $this->message = $message;

        parent::__construct($subject, $channels);
    }

    public function getMessage(): ActivityLogMessage
    {
        return $this->message;
    }
}
