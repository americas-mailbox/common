<?php
declare(strict_types=1);

use Phinx\Migration\AbstractMigration;

final class AddColumnsToAccounts extends AbstractMigration
{
    public function change()
    {
        $this->table('accounts')
            ->addColumn('next_renewal_date', 'date', ['null' => true])
            ->addColumn('plan_id', 'integer', ['null' => true,])
            ->addColumn('renewal_frequency', 'char', ['null' => true, 'length' => 20])
            ->update();
    }
}
