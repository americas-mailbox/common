<?php
declare(strict_types=1);

use Cake\Database\Query;
use Phinx\Migration\AbstractMigration;

final class TransferMembershipData extends AbstractMigration
{
    public function change()
    {
        $sql = <<<SQL
SELECT accounts.default_address_id, accounts.office_closed_delivery, accounts.id 
FROM accounts 
SQL;
        $stmt = $this->query($sql);
        $accounts = $stmt->fetchAll();
        foreach ($accounts as $account) {
            $this->moveData($account);
        }
    }

    private function moveData(array $account): void
    {
        $query = $this->getQueryBuilder(Query::TYPE_UPDATE);
        $query
            ->update('memberships')
            ->set('default_address_id', $account['default_address_id'])
            ->set('office_closed_delivery', $account['office_closed_delivery'])
            ->where(['account_id' => $account['id']])
            ->execute();
    }
}
