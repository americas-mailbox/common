<?php
declare(strict_types=1);

use Phinx\Migration\AbstractMigration;

final class AddMilitaryAndDiplomaticDelivery extends AbstractMigration
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
                'active'               => 0,
                'company_id'           => 4,
                'id'                   => 24,
                'internal_label'       => 'Military & Diplomatic',
                'internal_short_label' => 'DPO',
                'label'                => 'Military & Diplomatic',
                'group'                => 'shipping',
                'weight'               => 2,
            ],
        ];
        $this->table('delivery_methods')->insert($deliveryMethods)->save();
    }
}
