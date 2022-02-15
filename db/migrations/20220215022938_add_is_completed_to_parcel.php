<?php
declare(strict_types=1);

use Phinx\Db\Adapter\MysqlAdapter;
use Phinx\Migration\AbstractMigration;

final class AddIsCompletedToParcel extends AbstractMigration
{
    public function change(): void
    {
        $this->table('parcels')
            ->addColumn('is_completed', 'boolean', ['default' => 0, 'limit' => MysqlAdapter::INT_TINY])
            ->update();
    }
}
