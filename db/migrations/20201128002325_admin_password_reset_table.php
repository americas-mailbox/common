<?php
declare(strict_types=1);

use Phinx\Migration\AbstractMigration;

final class AdminPasswordResetTable extends AbstractMigration
{
    public function up(): void
    {
        $this->table('admin_password_reset')
            ->addColumn('token', 'char', ['limit' => '20'])
            ->addColumn('ip_address', 'char', ['limit' => '40'])
            ->addColumn('user_id', 'uuid')
            ->addTimestamps()
            ->addIndex('token', ['unique' => true])
            ->create();
    }

    public function down()
    {
        $this->table('admin_password_reset')->drop()->save();
    }
}
