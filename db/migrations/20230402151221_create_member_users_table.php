<?php
declare(strict_types=1);

use Phinx\Migration\AbstractMigration;

final class CreateMemberUsersTable extends AbstractMigration
{
    public function up(): void
    {
        ($this->table('member_users'))
            ->addColumn('email', 'char', ['limit' => '255'])
            ->addColumn('membership_id', 'integer', ['signed' => false])
            ->addColumn('name', 'char', ['null' => true, 'limit' => '255'])
            ->addColumn('phone', 'char', ['limit' => '255'])
            ->addColumn('last_login_ip', 'varbinary', ['limit' => 16, 'null' => true])
            ->addColumn('last_login_date', 'datetime', ['null' => true])
            ->addTimestamps()
            ->create();
    }

    public function down()
    {
        $this->table('member_users')->drop()->save();
    }
}
