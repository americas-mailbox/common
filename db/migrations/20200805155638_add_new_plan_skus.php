<?php
declare(strict_types=1);

use Phinx\Migration\AbstractMigration;

final class AddNewPlanSkus extends AbstractMigration
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
                'id' => 109,
                'description' => 'New Gold Plan (3 Months)',
                'name'        => 'PLAN_GOLD_3MO_NEW',
                'price'       => '{"amount":5697,"currency":"USD"}',
                'taxable'     => 1,
                'active'      => 1,
            ],
            [
                'id' => 110,
                'description' => 'New Gold Plan (6 Months)',
                'name'        => 'PLAN_GOLD_6MO_NEW',
                'price'       => '{"amount":11394,"currency":"USD"}',
                'taxable'     => 1,
                'active'      => 1,
            ],
            [
                'id' => 111,
                'description' => 'New Silver Plan (3 Months)',
                'name'        => 'PLAN_SILVER_3MO_NEW',
                'price'       => '{"amount":4797,"currency":"USD"}',
                'taxable'     => 1,
                'active'      => 1,
            ],
            [
                'id' => 112,
                'description' => 'New Silver Plan (6 Months)',
                'name'        => 'PLAN_SILVER_6MO_NEW',
                'price'       => '{"amount":9594,"currency":"USD"}',
                'taxable'     => 1,
                'active'      => 1,
            ],
        ];
        $this->table('products')->insert($skus)->save();

        $productCategories = [
            [
                'category_id' => 3,
                'product_id' => 109,
            ],
            [
                'category_id' => 4,
                'product_id' => 109,
            ],
            [
                'category_id' => 3,
                'product_id' => 110,
            ],
            [
                'category_id' => 4,
                'product_id' => 110,
            ],
            [
                'category_id' => 3,
                'product_id' => 111,
            ],
            [
                'category_id' => 4,
                'product_id' => 111,
            ],
            [
                'category_id' => 3,
                'product_id' => 112,
            ],
            [
                'category_id' => 4,
                'product_id' => 112,
            ],
        ];
        $this->table('product_categories')->insert($productCategories)->save();
    }
}
