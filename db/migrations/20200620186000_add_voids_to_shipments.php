<?php

use Phinx\Db\Adapter\MysqlAdapter;
use Phinx\Migration\AbstractMigration;

class AddVoidsToShipments extends AbstractMigration
{
    /**
     * Change Method.
     *
     * Write your reversible migrations using this method.
     *
     * More information on writing migrations is available here:
     * https://book.cakephp.org/phinx/0/en/migrations.html#the-change-method
     *
     * Remember to call "create()" or "update()" and NOT "save()" when working
     * with the Table class.
     */
    public function change()
    {
        $this->table('shipments')
            ->addColumn('voided', 'boolean', [
                'default' => false
            ])
            ->addColumn('voided_date', 'datetime', [
                'default' => null,
                'null' => true,
            ])
            ->addColumn('voided_ledger_item', 'integer', [
                'default' => null,
                'limit' => MysqlAdapter::INT_REGULAR,
                'null' => true,
                'signed' => false,
            ])
            ->update();
    }
}