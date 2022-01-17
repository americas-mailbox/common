<?php
declare(strict_types=1);

use Phinx\Migration\AbstractMigration;

final class CreateMemberAuthLookupTable extends AbstractMigration
{
    public function up()
    {
        ($this->table('auth_lookups', ['id' => false, 'primary_key' => 'id']))
            ->addColumn('email', 'char', ['limit' => 255])
            ->addColumn('id', 'uuid')
            ->addColumn('membership_id', 'integer', ['null' => true])
            ->addColumn('password', 'char', ['limit' => 255])
            ->addColumn('username', 'char', ['limit' => 50])
            ->addForeignKey('membership_id', 'members', 'member_id')
            ->addIndex('email', ['unique' => true])
            ->addIndex('username')
            ->addTimestamps()
            ->create();
    }

    public function down()
    {
        $this->table('auth_lookups')->drop()->save();
    }
}
