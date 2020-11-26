<?php

use Phinx\Migration\AbstractMigration;

class AddPushedToEndpointFlagToShipments extends AbstractMigration
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
            ->addColumn('pushed_to_endpoint', 'boolean', [
                'default' => false
            ])
            ->update();
    }
}
