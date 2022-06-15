<?php
declare(strict_types=1);

use Phinx\Migration\AbstractMigration;

final class CreateMemberAuthTable extends AbstractMigration
{
    public function up()
    {
        ($this->table('member_auth_lookups', ['id' => false, 'primary_key' => 'id']))
            ->addColumn('email', 'char', ['limit' => 255])
            ->addColumn('id', 'uuid')
            ->addColumn('password', 'char', ['limit' => 255])
            ->addColumn('user_id', 'char', ['limit' => 235, 'null' => true])
            ->addColumn('username', 'char', ['limit' => 50])
            ->addTimestamps()
            ->addIndex('username', ['unique' => true])
            ->create();
    }

    public function down()
    {
        $this->table('member_auth_lookups')->drop()->save();
    }
}
