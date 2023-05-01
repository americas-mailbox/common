<?php
declare(strict_types=1);

use Phinx\Migration\AbstractMigration;

final class DropColumnsInAccounts extends AbstractMigration
{
    public function change()
    {
        $this->table('accounts')
            ->removeColumn('default_address_id')
            ->removeColumn('office_closed_delivery')
            ->save();
    }
}
