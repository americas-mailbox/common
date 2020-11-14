<?php
declare(strict_types=1);

namespace AMB\Notification;

use Notification\Notification;

final class GenericNotification extends Notification
{
    protected function getEmailTemplate(): ?string
    {
        return 'generic';
    }
}
