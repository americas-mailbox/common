<?php

use Phinx\Migration\AbstractMigration;

class AddDeliveryCompanies extends AbstractMigration
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
        $data = [
            [
                'id'   => 1,
                'name' => 'Air Cargo ',
            ],
            [
                'id'   => 2,
                'name' => 'FedEx',
            ],
            [
                'id'   => 3,
                'name' => 'UPS',
            ],
            [
                'id'   => 4,
                'name' => 'US Postal Service',
            ],
            [
                'id'   => 5,
                'name' => 'DHL',
            ],
        ];
        $companyTable = $this->table('delivery_companies');
        $companyTable
            ->insert($data)
            ->save();
    }
}
