<?php
declare(strict_types=1);

use Phinx\Db\Adapter\MysqlAdapter;
use Phinx\Migration\AbstractMigration;

final class AddNeedsPasswordRestFlagToMember extends AbstractMigration
{
    public function change(): void
    {
        $this->table('members')
            ->addColumn('is_needing_password_reset', 'integer', ['limit' => MysqlAdapter::INT_TINY, 'default' => 1])
            ->update();
    }
}
