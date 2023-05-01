<?php
declare(strict_types=1);

use Phinx\Db\Adapter\MysqlAdapter;
use Phinx\Migration\AbstractMigration;

final class AddPrimaryFlagInMembers extends AbstractMigration
{
    public function change(): void
    {
        $this->table('members')
            ->addColumn('is_primary', 'integer', ['limit' => MysqlAdapter::INT_TINY, 'default' => 0])
            ->update();
    }
}
