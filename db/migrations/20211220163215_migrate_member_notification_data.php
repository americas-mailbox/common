<?php
declare(strict_types=1);

use AMB\Interactor\RapidCityTime;
use Phinx\Migration\AbstractMigration;

final class MigrateMemberNotificationData extends AbstractMigration
{
    public function change(): void
    {
        $sql = <<<SQL
SELECT 
       account_id,
       lowBalanceDateNotified,
       lowBalanceNumNotifications,
       suspendedmessage
FROM members
SQL;
        $statement = $this->query($sql);
        $members = $statement->fetchAll();
        foreach ($members as $memberData) {
            if ($memberData['lowBalanceDateNotified']) {
                $notificationDate = (new RapidCityTime($memberData['lowBalanceDateNotified']))->toDateTimeString();
            }
            $notifications = json_encode([
                'lastSuspendedNotificationDate'  => null,
                'lastLowBalanceNotificationDate' => $notificationDate ?? null,
                'lowBalanceNotificationCount'    => (int)$memberData['lowBalanceNumNotifications'],
                'reasonForSuspension'            => $memberData['suspendedmessage'],
                'suspendedNotificationCount'     => 0,
                'suspensionCodes'                => $this->getSuspensionCodes($memberData['suspendedmessage'] ?? ''),
            ]);
            $this->getQueryBuilder()
                ->update('accounts')
                ->set('notifications', $notifications)
                ->where(['id' => $memberData['account_id']])
                ->execute();
        }
    }

    private function getSuspensionCodes(string $message): array
    {
        if (empty($message)) {
            return [];
        }
        $message = strtolower($message);
        $codes = [];
        if (
            str_contains($message, 'expired')
            || str_contains($message, 'overdue')
            || str_contains($message, 'over due')
            || str_contains($message, 'past due')
        ) {
            $codes[] = 'EXPIRED_ACCOUNT';
        }
        if (
            str_contains($message, 'balance')
            || str_contains($message, 'critical balance')
            || str_contains($message, 'postage')
        ) {
            $codes[] = 'LOW_FUNDS';
        }
        if (
            str_contains($message, 'agreement')
            || str_contains($message, 'document')
            || str_contains($message, 'form')
            || str_contains($message, 'id')
            || str_contains($message, 'paperwork')
            || str_contains($message, '1583')
        ) {
            $codes[] = 'MISSING_DOCUMENTATION';
        }

        return empty($codes) ? ['OTHER'] : array_values($codes);
    }
}
