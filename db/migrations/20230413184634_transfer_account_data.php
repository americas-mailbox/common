<?php
declare(strict_types=1);

use Cake\Database\Query;
use Phinx\Migration\AbstractMigration;

final class TransferAccountData extends AbstractMigration
{
    public function change()
    {
        $stmt = $this->query('SELECT * FROM memberships');
        $memberships = $stmt->fetchAll();
        foreach ($memberships as $membership) {
            $this->moveData($membership);
        }
    }

    private function moveData(array $membership): void
    {
        $query = $this->getQueryBuilder(Query::TYPE_UPDATE);
        $query
            ->update('accounts')
            ->set('next_renewal_date', $membership['next_renewal_date'])
            ->set('plan_id', $membership['plan_id'])
            ->set('renewal_frequency', $membership['renewal_frequency'])
            ->where(['id' => $membership['account_id']])
            ->execute();
    }
}
