<?php

use Phinx\Migration\AbstractMigration;

class AddMoreFedExServiceCodes extends AbstractMigration
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
        $data = [
            [
                'delivery_method_id' => 12,
                'service_code'       => 'fedex_first_overnight',
            ],
            [
                'delivery_method_id' => 12,
                'service_code'       => 'fedex_priority_overnight',
            ],
            [
                'delivery_method_id' => 12,
                'service_code'       => 'fedex_standard_overnight',
            ],
        ];
        $this->table('delivery_methods_services')->insert($data)->save();
    }
}
