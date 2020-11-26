<?php

use Phinx\Migration\AbstractMigration;

class CreateDeliveriesTable extends AbstractMigration
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
        $table = $this->table('deliveries');
        $table
            ->addColumn('charges_base', 'json')
            ->addColumn('charges_surcharges', 'json')
            ->addColumn('charges_total', 'json')
            ->addColumn('carrier_id', 'integer', ['signed' => false])
            ->addColumn('service_code', 'string')
            ->addColumn('tracking_number', 'string')
            ->addColumn('zone', 'string')
            ->addColumn('weight_amount', 'string')
            ->addColumn('weight_type', 'string')
            ->addColumn('weight_unit', 'string')
            ->create();
    }
}
