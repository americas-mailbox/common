<?php
declare(strict_types=1);

use Phinx\Migration\AbstractMigration;

final class AddPostageChargeSku extends AbstractMigration
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
        $sku = [
            [
                'id'          => 122,
                'description' => 'Postage Charge',
                'name'        => 'POSTAGE_CHARGE',
                'price'       => '{"amount":0,"currency":"USD"}',
                'taxable'     => 0,
                'active'      => 1,
            ],
        ];
        $this->table('products')->insert($sku)->save();

        $productCategories = [
            [
                'category_id' => 1,
                'product_id'  => 122,
            ],
        ];
        $this->table('product_categories')->insert($productCategories)->save();
    }
}
