<?php
declare(strict_types=1);

use Phinx\Migration\AbstractMigration;

final class AdminUsersTable extends AbstractMigration
{
    public function up()
    {
        ($this->table('admin_users', ['id' => false, 'primary_key' => 'id']))
            ->addColumn('email', 'char', ['limit' => 255])
            ->addColumn('id', 'uuid')
            ->addColumn('password', 'char', ['limit' => 255])
            ->addColumn('person_id', 'char', ['limit' => 235, 'null' => true])
            ->addColumn('username', 'char', ['limit' => 50])
            ->addTimestamps()
            ->addIndex('username', ['unique' => true])
            ->create();
    }

    public function down()
    {
        $this->table('admin_users')->drop()->save();
    }
}
