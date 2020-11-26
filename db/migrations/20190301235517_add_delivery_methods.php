<?php
declare(strict_types=1);

use Phinx\Migration\AbstractMigration;

final class AddDeliveryMethods extends AbstractMigration
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
                'id'         => 1,
                'label'      => 'Air Cargo - 2nd Day Air',
                'group'      => 'shipping',
                'weight'     => 2,
                'active'     => 0,
                'company_id' => 1,
            ],
            [
                'id'         => 2,
                'label'      => 'Air Cargo - 3rd Day Air',
                'group'      => 'shipping',
                'weight'     => 2,
                'active'     => 0,
                'company_id' => 1,
            ],
            [
                'id'         => 3,
                'label'      => 'Air Cargo - Ground',
                'group'      => 'shipping',
                'weight'     => 2,
                'active'     => 0,
                'company_id' => 1,
            ],
            [
                'id'         => 4,
                'label'      => 'Air Cargo - Overnight',
                'group'      => 'shipping',
                'weight'     => 2,
                'active'     => 0,
                'company_id' => 1,
            ],
            [
                'id'         => 5,
                'label'      => 'Best Method',
                'group'      => 'shipping',
                'weight'     => 1,
                'active'     => 1,
                'company_id' => 0,
            ],
            [
                'id'         => 6,
                'label'      => 'Best Method - International',
                'group'      => 'international',
                'weight'     => 1,
                'active'     => 1,
                'company_id' => 0,
            ],
            [
                'id'         => 7,
                'label'      => 'Customer Pick Up',
                'group'      => 'pickup',
                'weight'     => 1,
                'active'     => 1,
                'company_id' => 0,
            ],
            [
                'id'         => 8,
                'label'      => '2nd Day Air',
                'group'      => 'shipping',
                'weight'     => 7,
                'active'     => 1,
                'company_id' => 2,
            ],
            [
                'id'         => 9,
                'label'      => '3rd Day Air',
                'group'      => 'shipping',
                'weight'     => 8,
                'active'     => 1,
                'company_id' => 2,
            ],
            [
                'id'         => 10,
                'label'      => 'Ground',
                'group'      => 'shipping',
                'weight'     => 9,
                'active'     => 1,
                'company_id' => 2,
            ],
            [
                'id'         => 11,
                'label'      => 'International',
                'group'      => 'international',
                'weight'     => 2,
                'active'     => 1,
                'company_id' => 2,
            ],
            [
                'id'         => 12,
                'label'      => 'Overnight',
                'group'      => 'shipping',
                'weight'     => 6,
                'active'     => 1,
                'company_id' => 2,
            ],
            [
                'id'         => 13,
                'label'      => 'UPS - Overnight',
                'group'      => 'shipping',
                'weight'     => 3,
                'active'     => 0,
                'company_id' => 0,
            ],
            [
                'id'         => 14,
                'label'      => 'Express 2 Day Service',
                'group'      => 'shipping',
                'weight'     => 5,
                'active'     => 1,
                'company_id' => 4,
            ],
            [
                'id'         => 15,
                'label'      => 'First Class (if available)',
                'group'      => 'shipping',
                'weight'     => 3,
                'active'     => 1,
                'company_id' => 4,
            ],
            [
                'id'         => 16,
                'label'      => 'International',
                'group'      => 'international',
                'weight'     => 4,
                'active'     => 1,
                'company_id' => 4,
            ],
            [
                'id'         => 17,
                'label'      => 'Priority',
                'group'      => 'shipping',
                'weight'     => 2,
                'active'     => 1,
                'company_id' => 4,
            ],
            [
                'id'         => 18,
                'label'      => '2nd Day',
                'group'      => 'shipping',
                'weight'     => 10,
                'active'     => 1,
                'company_id' => 2,
            ],
            [
                'id'         => 19,
                'label'      => 'DHL - Overnight',
                'group'      => 'shipping',
                'weight'     => 2,
                'active'     => 0,
                'company_id' => 0,
            ],
        ];
        $this->table('delivery_methods')->insert($deliveryMethods)->save();
    }
}
