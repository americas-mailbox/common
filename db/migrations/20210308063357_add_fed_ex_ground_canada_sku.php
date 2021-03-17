<?php
declare(strict_types=1);

use Phinx\Migration\AbstractMigration;

final class AddFedExGroundCanadaSku extends AbstractMigration
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
                'id'          => 123,
                'description' => 'FedEx Ground Canada',
                'name'        => 'FEDEX_GROUND_CANADA',
                'price'       => '{"amount": 510,"currency":"USD"}',
                'taxable'     => 1,
                'active'      => 1,
            ],
        ];
        $this->table('products')->insert($skus)->save();
        $productCategories = [
            [
                'category_id' => 2,
                'product_id'  => 123,
            ],
        ];
        $this->table('product_categories')->insert($productCategories)->save();
    }
}
