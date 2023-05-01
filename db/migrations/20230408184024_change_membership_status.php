<?php
declare(strict_types=1);

use Phinx\Db\Adapter\MysqlAdapter;
use Phinx\Migration\AbstractMigration;

final class ChangeMembershipStatus extends AbstractMigration
{
    public function change(): void
    {
        $this->table('memberships')
            ->renameColumn('status', 'old_status')
            ->save();
        $this->table('memberships')
            ->addColumn('status',
                MysqlAdapter::PHINX_TYPE_ENUM,
                [
                    'values' => ['ACTIVE','CLOSED','SUSPENDED','UNVERIFIED'],
                    'default' => 'UNVERIFIED',
                ])
            ->save();
    }
}
