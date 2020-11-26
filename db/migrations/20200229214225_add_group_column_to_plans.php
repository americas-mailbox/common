<?php

use Phinx\Migration\AbstractMigration;

class AddGroupColumnToPlans extends AbstractMigration
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
            ->addColumn('group', 'char', ['limit' => 20, 'null' => false])
            ->update();
        $this->getQueryBuilder()
            ->update('rates_and_plans')
            ->set('group', 'BRONZE')
            ->where(['title' => 'Bronze'])
            ->execute();
        $this->getQueryBuilder()
            ->update('rates_and_plans')
            ->set('group', 'SILVER')
            ->where(['title' => 'Silver'])
            ->execute();
        $this->getQueryBuilder()
            ->update('rates_and_plans')
            ->set('group', 'GOLD')
            ->where(['title' => 'Gold'])
            ->execute();
        $this->getQueryBuilder()
            ->update('rates_and_plans')
            ->set('group', 'PLATINUM')
            ->where(['title' => 'Platinum'])
            ->execute();
        $this->getQueryBuilder()
            ->update('rates_and_plans')
            ->set('group', 'TITANIUM')
            ->where(['title' => 'Titanium Scanning'])
            ->execute();
        $this->getQueryBuilder()
            ->update('rates_and_plans')
            ->set('group', 'TITANIUM')
            ->where(['title' => 'Titanium Plus'])
            ->execute();
        $this->getQueryBuilder()
            ->update('rates_and_plans')
            ->set('group', 'TITANIUM')
            ->where(['title' => 'Short Term Titanium Plus'])
            ->execute();
    }
}
