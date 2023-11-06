<?php
declare(strict_types=1);

namespace AMB\Interactor\Db;

use AMB\Entity\Account\Notifications;
use AMB\Interactor\RapidCityTime;

final class HydrateAccountNotification
{
    public function hydrate(array $data): Notifications
    {
        $lastLowBalanceNotificationDate = $this->hydrateDate($data['lastLowBalanceNotificationDate']??null);
        $lastSuspendedNotificationDate = $this->hydrateDate($data['lastSuspendedNotificationDate']??null);

        return (new Notifications())
            ->setLastLowBalanceNotificationDate($lastLowBalanceNotificationDate)
            ->setLastSuspendedNotificationDate($lastSuspendedNotificationDate)
            ->setLowBalanceNotificationCount($data['lowBalanceNotificationCount']??0)
            ->setReasonForSuspension($data['reasonForSuspension']??'')
            ->setSuspendedNotificationCount($data['suspendedNotificationCount']??0)
            ->setSuspensionCodes($data['suspensionCodes']??[]);
    }

    private function hydrateDate(?string $date): ?RapidCityTime
    {
        return $date ? new RapidCityTime($date) : null;
    }
}
