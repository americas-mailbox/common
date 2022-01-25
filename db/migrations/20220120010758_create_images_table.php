<?php
declare(strict_types=1);

use Phinx\Migration\AbstractMigration;

final class CreateImagesTable extends AbstractMigration
{
    public function up(): void
    {
        ($this->table('images', ['id' => false, 'primary_key' => 'id']))
            ->addColumn('id', 'uuid')
            ->addColumn('filepath', 'char', ['limit' => '255'])
            ->addTimestamps()
            ->create();
    }

    public function down()
    {
        $this->table('images')->drop()->save();
    }
}
