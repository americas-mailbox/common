<?php
declare(strict_types=1);

use Phinx\Migration\AbstractMigration;

final class CreateScannedPagesTable extends AbstractMigration
{
    public function up(): void
    {
        ($this->table('scanned_pages'))
            ->addColumn('filepath', 'char', ['limit' => '255'])
            ->addColumn('file_id', 'uuid')
            ->addColumn('machine_id', 'char', ['limit' => '255'])
            ->addColumn('scan_id', 'char', ['limit' => '255', 'null' => true])
            ->addTimestamps()
            ->create();
    }

    public function down()
    {
        $this->table('scanned_pages')->drop()->save();
    }
}
