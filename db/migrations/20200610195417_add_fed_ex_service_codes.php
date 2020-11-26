<?php

use Phinx\Migration\AbstractMigration;

class AddFedExServiceCodes extends AbstractMigration
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
                'delivery_method_id' => 9,
                'service_code'       => 'fedex_express_saver',
            ],
            [
                'delivery_method_id' => 10,
                'service_code'       => 'fedex_ground',
            ],
            [
                'delivery_method_id' => 10,
                'service_code'       => 'fedex_ground_home_delivery',
            ],
            [
                'delivery_method_id' => 11,
                'service_code'       => 'fedex_international_economy',
            ],
            [
                'delivery_method_id' => 11,
                'service_code'       => 'fedex_international_priority',
            ],
            [
                'delivery_method_id' => 18,
                'service_code'       => 'fedex_two_day',
            ],
            [
                'delivery_method_id' => 18,
                'service_code'       => 'fedex_two_day_am',
            ],
        ];
        $this->table('delivery_methods_services')->insert($data)->save();
    }
}
