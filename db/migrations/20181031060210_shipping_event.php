<?php

use Phinx\Db\Adapter\MysqlAdapter;
use Phinx\Migration\AbstractMigration;

class ShippingEvent extends AbstractMigration
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
        $table = $this->table('shipping_events');
        $table
            ->addColumn('address_id', 'integer', ['null' => true])
            ->addColumn('delivery_id', 'integer')
            ->addColumn('end_timestamp', 'integer', ['signed' => false])
            ->addColumn('is_active', 'integer', ['limit' => MysqlAdapter::INT_TINY, 'signed' => false])
            ->addColumn('member_id', 'integer')
            ->addColumn('recurrence_id', 'integer', ['null' => true])
            ->addColumn('start_timestamp', 'integer', ['signed' => false])
            ->create();
    }
}
