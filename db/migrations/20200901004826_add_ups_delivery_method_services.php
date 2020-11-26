<?php
declare(strict_types=1);

use Phinx\Migration\AbstractMigration;

final class AddUpsDeliveryMethodServices extends AbstractMigration
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
    public function change(): void
    {
        $data = [
            [
                'delivery_method_id' => 20,
                'service_code'       => 'ups_ground',
            ],
            [
                'delivery_method_id' => 21,
                'service_code'       => 'ups_next_day_air',
            ],
            [
                'delivery_method_id' => 22,
                'service_code'       => 'ups_second_day_air',
            ],
            [
                'delivery_method_id' => 23,
                'service_code'       => 'ups_three_day_select',
            ],
        ];
        $this->table('delivery_methods_services')->insert($data)->save();
    }
}
