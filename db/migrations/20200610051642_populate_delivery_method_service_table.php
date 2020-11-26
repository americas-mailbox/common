<?php

use Phinx\Migration\AbstractMigration;

class PopulateDeliveryMethodServiceTable extends AbstractMigration
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
                'service_code'       => 'FEDEX_EXPRESS_SAVER',
            ],
            [
                'delivery_method_id' => 10,
                'service_code'       => 'FEDEX_GROUND',
            ],
            [
                'delivery_method_id' => 10,
                'service_code'       => 'GROUND_HOME_DELIVERY',
            ],
            [
                'delivery_method_id' => 11,
                'service_code'       => 'INTERNATIONAL_ECONOMY',
            ],
            [
                'delivery_method_id' => 11,
                'service_code'       => 'INTERNATIONAL_PRIORITY',
            ],
            [
                'delivery_method_id' => 12,
                'service_code'       => 'FIRST_OVERNIGHT',
            ],
            [
                'delivery_method_id' => 12,
                'service_code'       => 'PRIORITY_OVERNIGHT',
            ],
            [
                'delivery_method_id' => 12,
                'service_code'       => 'STANDARD_OVERNIGHT',
            ],
            [
                'delivery_method_id' => 14,
                'service_code'       => 'usps_express',
            ],
            [
                'delivery_method_id' => 15,
                'service_code'       => 'usps_first_class',
            ],
            [
                'delivery_method_id' => 16,
                'service_code'       => 'usps_international_express',
            ],
            [
                'delivery_method_id' => 16,
                'service_code'       => 'usps_international_first_class',
            ],
            [
                'delivery_method_id' => 16,
                'service_code'       => 'usps_international_priority',
            ],
            [
                'delivery_method_id' => 17,
                'service_code'       => 'usps_priority',
            ],
            [
                'delivery_method_id' => 18,
                'service_code'       => 'FEDEX_2_DAY',
            ],
            [
                'delivery_method_id' => 18,
                'service_code'       => 'FEDEX_2_DAY_AM',
            ],
        ];
        $this->table('delivery_methods_services')->insert($data)->save();
    }
}
