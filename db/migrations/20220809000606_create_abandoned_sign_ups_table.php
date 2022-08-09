<?php
declare(strict_types=1);

use Phinx\Migration\AbstractMigration;

final class CreateAbandonedSignUpsTable extends AbstractMigration
{
    public function up(): void
    {
        ($this->table('abandoned_sign_ups'))
            ->addColumn('email', 'char', ['limit' => '255'])
            ->addColumn('fullName', 'char', ['null' => true, 'limit' => '255'])
            ->addColumn('phone', 'char', ['limit' => '255'])
            ->addColumn('pmb', 'char', ['null' => true, 'limit' => '255'])
            ->addColumn('status', 'char', ['limit' => '255'])
            ->addTimestamps()
            ->create();
    }

    public function down()
    {
        $this->table('abandoned_sign_ups')->drop()->save();
    }
}
