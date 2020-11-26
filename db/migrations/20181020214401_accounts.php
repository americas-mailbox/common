<?php

use Phinx\Db\Adapter\MysqlAdapter;
use Phinx\Migration\AbstractMigration;

class Accounts extends AbstractMigration
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
        $this->table('accounts')
            ->addColumn('auto_renew', 'integer',  ['limit' => MysqlAdapter::INT_TINY])
            ->addColumn('auto_top_up', 'integer',  ['limit' => MysqlAdapter::INT_TINY])
            ->addColumn('critical_balance', 'text')
            ->addColumn('custom_auto_top_up', 'integer',  ['limit' => MysqlAdapter::INT_TINY])
            ->addColumn('custom_critical_balance', 'integer',  ['limit' => MysqlAdapter::INT_TINY])
            ->addColumn('custom_minimum_allowed_balance', 'integer',  ['limit' => MysqlAdapter::INT_TINY])
            ->addColumn('default_card_id', 'integer', ['null' => true])
            ->addColumn('ledger_id', 'integer')
            ->addColumn('minimum_allowed_balance', 'text')
            ->addColumn('top_up_amount', 'text')
            ->create();
    }
}
