<?php
declare(strict_types=1);

use Phinx\Migration\AbstractMigration;

final class AddAccountNotificationsToAccounts extends AbstractMigration
{
    public function change(): void
    {
        $this->table('accounts')
            ->addColumn('notifications', 'json')
            ->update();

        $default = json_encode(
            [
                'lowBalanceNotificationDates' => [],
                'lowBalanceNotificationCount' => 0,
                'suspendedNotificationCount'  => 0,
                'reasonForSuspension'         => '',
            ]
        );
        $this->getQueryBuilder()
            ->update('accounts')
            ->set('notifications', $default)
            ->execute();
    }
}
