<?php
declare(strict_types=1);

use Phinx\Db\Adapter\MysqlAdapter;
use Phinx\Migration\AbstractMigration;

final class AddDashboardSelectionToMembers extends AbstractMigration
{
    public function change(): void
    {
        $this->table('members')
            ->addColumn('use_new_dashboard', 'boolean', ['default' => 0, 'limit' => MysqlAdapter::INT_TINY])
            ->update();
    }
}
