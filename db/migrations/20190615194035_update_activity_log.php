<?php

use Phinx\Migration\AbstractMigration;

class UpdateActivityLog extends AbstractMigration
{
    /**
     * Change Method.
     *
     * Write your reversible migrations using this method.
     *
     * More information on writing migrations is available here:
     * http://docs.phinx.org/en/latest/migrations.html#the-abstractmigration-class
     *
     * The following commands can be used in this method and Phinx will
     * automatically reverse them when rolling back:
     *
     *    createTable
     *    renameTable
     *    addColumn
     *    addCustomColumn
     *    renameColumn
     *    addIndex
     *    addForeignKey
     *
     * Any other destructive changes will result in an error when trying to
     * rollback the migration.
     *
     * Remember to call "create()" or "update()" and NOT "save()" when working
     * with the Table class.
     */
    public function change()
    {
        $table = $this->table('activity_log');
        $table->truncate();

        $this->table('activity_log')
            ->addColumn('actor_admin_id', 'integer', ['signed' => false, 'null' => true])
            ->addColumn('actor_member_id', 'integer', ['signed' => false, 'null' => true])
            ->addColumn('actor_system_id', 'integer', ['signed' => false, 'null' => true])
            ->addColumn('date', 'date')
            ->addColumn('target_admin_id', 'integer', ['signed' => false, 'null' => true])
            ->addColumn('target_member_id', 'integer', ['signed' => false, 'null' => true])
            ->addColumn('target_system_id', 'integer', ['signed' => false, 'null' => true])
            ->removeColumn('boxnum')
            ->removeColumn('is_admin')
            ->removeColumn('loggedin_userid')
            ->removeColumn('loggedin_username')
            ->removeColumn('loggedin_userdesc')
            ->removeColumn('userdesc')
            ->removeColumn('userid')
            ->removeColumn('username')
            ->renameColumn('officeid', 'office_id')
            ->save();
    }
}
