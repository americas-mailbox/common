<?php

use Phinx\Migration\AbstractMigration;

class UpdatePriceInPlans extends AbstractMigration
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
            ->changeColumn('price', 'json')
            ->update();
        $this->getQueryBuilder()
            ->update('rates_and_plans')
            ->set('price', '{"amount": 12900, "currency": "USD"}')
            ->where(['title' => 'Bronze'])
            ->execute();
        $this->getQueryBuilder()
            ->update('rates_and_plans')
            ->set('price', '{"amount": 14900, "currency": "USD"}')
            ->where(['title' => 'Silver'])
            ->execute();
        $this->getQueryBuilder()
            ->update('rates_and_plans')
            ->set('price', '{"amount": 18900, "currency": "USD"}')
            ->where(['title' => 'Gold'])
            ->execute();
        $this->getQueryBuilder()
            ->update('rates_and_plans')
            ->set('price', '{"amount": 22900, "currency": "USD"}')
            ->where(['title' => 'Platinum'])
            ->execute();
        $this->getQueryBuilder()
            ->update('rates_and_plans')
            ->set('price', '{"amount": 22800, "currency": "USD"}')
            ->where(['title' => 'Titanium Scanning'])
            ->execute();
        $this->getQueryBuilder()
            ->update('rates_and_plans')
            ->set('price', '{"amount": 22800, "currency": "USD"}')
            ->where(['title' => 'Titanium Plus'])
            ->execute();
        $this->getQueryBuilder()
            ->update('rates_and_plans')
            ->set('price', '{"amount": 15900, "currency": "USD"}')
            ->where(['title' => 'Titanium Lucky 7'])
            ->execute();
        $this->getQueryBuilder()
            ->update('rates_and_plans')
            ->set('price', '{"amount": 2500, "currency": "USD"}')
            ->where(['title' => 'Short Term Titanium Plus'])
            ->execute();
    }
}
