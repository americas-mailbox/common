<?php
declare(strict_types=1);

use Phinx\Db\Adapter\MysqlAdapter;
use Phinx\Migration\AbstractMigration;

final class AddPrimaryFlagToMemberAuthLookupTable extends AbstractMigration
{
    public function change(): void
    {
        $this->table('member_auth_lookups')
            ->addColumn('is_primary', 'integer', ['default' => 1, 'limit' => MysqlAdapter::INT_TINY, 'signed' => false])
            ->update();
    }
}
