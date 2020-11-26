<?php

use Phinx\Db\Adapter\MysqlAdapter;
use Phinx\Migration\AbstractMigration;

class CreateDeliveryMethodServiceTable extends AbstractMigration
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
        $table = $this->table('delivery_methods_services', ['id' => false]);
        $table
            ->addColumn('delivery_method_id', 'integer', ['limit' => MysqlAdapter::INT_REGULAR, 'signed' => false])
            ->addColumn('service_code', 'string')
            ->create();
    }
}
