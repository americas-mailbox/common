<?php
declare(strict_types=1);

use Phinx\Db\Adapter\MysqlAdapter;
use Phinx\Migration\AbstractMigration;

final class AddEmergencyClosureFlagToOfficeClosures extends AbstractMigration
{
    public function change(): void
    {
        $this->table('office_closures')
            ->addColumn('emergency_closure', 'integer', ['limit' => MysqlAdapter::INT_TINY, 'default' => 0])
            ->update();
    }
}
