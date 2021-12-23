<?php
declare(strict_types=1);

namespace AMB\Interactor\Db;

use AMB\Entity\Account\Notifications;
use AMB\Interactor\RapidCityTime;

final class HydrateAccountNotification
{
    public function hydrate(array $data): Notifications
    {
        $lowBalanceNotificationDates = $this->hydrateDates($data['lowBalanceNotificationDates']);
        $suspendedNotificationDates = $this->hydrateDates($data['suspendedNotificationDates']);

        return (new Notifications())
            ->setLowBalanceNotificationCount($data['lowBalanceNotificationCount'])
            ->setLowBalanceNotificationDates($lowBalanceNotificationDates)
            ->setReasonForSuspension($data['reasonForSuspension'])
            ->setSuspendedNotificationCount($data['suspendedNotificationCount'])
            ->setSuspendedNotificationDates($suspendedNotificationDates)
            ->setSuspensionCodes($data['suspensionCodes']);
    }

    private function hydrateDates(array $dates): array
    {
        $data = [];
        foreach ($dates as $date) {
            $data[] = new RapidCityTime($date);
        }

        return $data;
    }
}
