<?php
declare(strict_types=1);

use Phinx\Migration\AbstractMigration;

final class CreateMemberPasswordResetTable extends AbstractMigration
{
    public function up(): void
    {
        $this->table('member_password_reset')
            ->addColumn('token', 'char', ['limit' => '20'])
            ->addColumn('ip_address', 'char', ['limit' => '40'])
            ->addColumn('auth_lookup_id', 'uuid')
            ->addIndex('token', ['unique' => true])
            ->addTimestamps()
            ->create();
    }

    public function down()
    {
        $this->table('member_password_reset')->drop()->save();
    }
}
