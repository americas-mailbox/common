<?php

use Phinx\Migration\AbstractMigration;

class UpdateSetUpFeeInPlans extends AbstractMigration
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
        $this->table('rates_and_plans')
            ->removeColumn('life_time_price')
            ->addColumn('set_up_fee', 'json')
            ->update();
        $this->getQueryBuilder()
            ->update('rates_and_plans')
            ->set('set_up_fee', '{"amount": 2500, "currency": "USD"}')
            ->execute();
    }
}
