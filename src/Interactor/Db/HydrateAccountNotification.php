<?php
declare(strict_types=1);

namespace AMB\Interactor\Db;

use AMB\Entity\Account\Notifications;

final class HydrateAccountNotification
{
    public function hydrate(array $data): Notifications
    {
        return (new Notifications())
            ->setLowBalanceNotificationCount($data['lowBalanceNotificationCount'])
            ->setLowBalanceNotificationDates($data['lowBalanceNotificationDates'])
            ->setReasonForSuspension($data['reasonForSuspension'])
            ->setSuspendedNotificationCount($data['suspendedNotificationCount']);
    }
}
