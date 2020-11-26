<?php
declare(strict_types=1);

use Phinx\Migration\AbstractMigration;

final class AddUpsDeliveryMethods extends AbstractMigration
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
        $deliveryMethods = [
            [
                'id'         => 20,
                'label'      => 'Ground',
                'group'      => 'shipping',
                'weight'     => 2,
                'active'     => 1,
                'company_id' => 3,
            ],
            [
                'id'         => 21,
                'label'      => 'Next Day Air',
                'group'      => 'shipping',
                'weight'     => 2,
                'active'     => 1,
                'company_id' => 3,
            ],
            [
                'id'         => 22,
                'label'      => '2nd Day Air',
                'group'      => 'shipping',
                'weight'     => 2,
                'active'     => 1,
                'company_id' => 3,
            ],
            [
                'id'         => 23,
                'label'      => '3 Day Select',
                'group'      => 'shipping',
                'weight'     => 2,
                'active'     => 1,
                'company_id' => 3,
            ],
        ];
        $this->table('delivery_methods')->insert($deliveryMethods)->save();
    }
}
