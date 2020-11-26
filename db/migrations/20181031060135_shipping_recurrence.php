<?php

use Phinx\Db\Adapter\MysqlAdapter;
use Phinx\Migration\AbstractMigration;

class ShippingRecurrence extends AbstractMigration
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
        $table = $this->table('shipping_recurrences');
        $table
            ->addColumn('daily', 'integer', ['limit' => MysqlAdapter::INT_TINY, 'signed' => false, 'default' => 0])
            ->addColumn('day_of_the_month', 'integer', [
                'limit' => MysqlAdapter::INT_TINY, 'signed' => false, 'null' => true
            ])
            ->addColumn('day_of_the_week', 'integer', [
                'limit' => MysqlAdapter::INT_TINY, 'signed' => false, 'null' => true
            ])
            ->addColumn('first_weekday_of_the_month', 'integer', ['limit' => MysqlAdapter::INT_TINY, 'signed' => false, 'null' => true])
            ->addColumn('last_weekday_of_the_month', 'integer', ['limit' => MysqlAdapter::INT_TINY, 'signed' => false, 'null' => true])
            ->addColumn('next_weekly', 'date', ['null' => true])
            ->addColumn('weeks_between', 'integer', ['limit' => MysqlAdapter::INT_TINY, 'signed' => false, 'null' => true])
        ->create();
    }
}
