<?php
declare(strict_types=1);

use Phinx\Migration\AbstractMigration;

final class AddUPSServiceSkus extends AbstractMigration
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
        $skus = [
            [
                'id'          => 113,
                'description' => 'UPS Ground',
                'name'        => 'UPS_GROUND',
                'price'       => '{"amount": 1100,"currency":"USD"}',
                'taxable'     => 1,
                'active'      => 1,
            ],
            [
                'id'          => 114,
                'description' => 'UPS Next Day Air',
                'name'        => 'UPS_NEXT_DAY_AIR',
                'price'       => '{"amount": 1100,"currency":"USD"}',
                'taxable'     => 1,
                'active'      => 1,
            ],
            [
                'id'          => 115,
                'description' => 'UPS 2nd Day Air',
                'name'        => 'UPS_2ND_DAY_AIR',
                'price'       => '{"amount": 1100,"currency":"USD"}',
                'taxable'     => 1,
                'active'      => 1,
            ],
            [
                'id'          => 116,
                'description' => 'UPS 3 Day Select',
                'name'        => 'UPS_3_DAY_SELECT',
                'price'       => '{"amount": 1100,"currency":"USD"}',
                'taxable'     => 1,
                'active'      => 1,
            ],
        ];
        $this->table('products')->insert($skus)->save();
        $productCategories = [
            [
                'category_id' => 2,
                'product_id'  => 113,
            ],
            [
                'category_id' => 2,
                'product_id'  => 114,
            ],
            [
                'category_id' => 2,
                'product_id'  => 115,
            ],
            [
                'category_id' => 2,
                'product_id'  => 116,
            ],
        ];
        $this->table('product_categories')->insert($productCategories)->save();
    }
}
