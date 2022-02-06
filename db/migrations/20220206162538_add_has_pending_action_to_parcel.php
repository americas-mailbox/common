<?php
declare(strict_types=1);

use Phinx\Db\Adapter\MysqlAdapter;
use Phinx\Migration\AbstractMigration;

final class AddHasPendingActionToParcel extends AbstractMigration
{
    public function change(): void
    {
        $this->table('parcels')
            ->addColumn('has_pending_action', 'boolean', ['default' => 0, 'limit' => MysqlAdapter::INT_TINY])
            ->update();
    }
}
