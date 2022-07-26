<?php
declare(strict_types=1);

use Phinx\Db\Adapter\MysqlAdapter;
use Phinx\Migration\AbstractMigration;

final class CreateScannedImagesTable extends AbstractMigration
{
    public function up(): void
    {
        ($this->table('scanned_images', ['id' => false, 'primary_key' => 'id']))
            ->addColumn('filepath', 'char', ['limit' => '255'])
            ->addColumn('id', 'uuid')
            ->addColumn('is_processed', 'boolean', ['default' => 0, 'limit' => MysqlAdapter::INT_TINY])
            ->addColumn('machine_id', 'char', ['limit' => '255'])
            ->addColumn('scanned_by_id', 'char', ['limit' => '255'])
            ->addColumn('scanned_by_role', 'char', ['limit' => '255'])
            ->addTimestamps()
            ->create();
    }

    public function down()
    {
        $this->table('scanned_images')->drop()->save();
    }
}
