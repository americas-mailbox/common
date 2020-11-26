<?php
declare(strict_types=1);

use Phinx\Migration\AbstractMigration;

final class AddMoreNotarySkus extends AbstractMigration
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
        $this->getQueryBuilder()
            ->update('products')
            ->set('name', 'NOTARY_OFFICE')
            ->where(['name' => 'NOT_01'])
            ->execute();
        $skus = [
            [
                'id'          => 117,
                'description' => 'Notary USA',
                'name'        => 'NOTARY_USA',
                'price'       => '{"amount":2500,"currency":"USD"}',
                'taxable'     => 1,
                'active'      => 1,
            ],
            [
                'id'          => 118,
                'description' => 'Notary International',
                'name'        => 'NOTARY_INTL',
                'price'       => '{"amount":7900,"currency":"USD"}',
                'taxable'     => 1,
                'active'      => 1,
            ],
        ];
        $this->table('products')->insert($skus)->save();
        $productCategories = [
            [
                'category_id' => 1,
                'product_id' => 117,
            ],
            [
                'category_id' => 2,
                'product_id' => 117,
            ],
            [
                'category_id' => 1,
                'product_id' => 118,
            ],
            [
                'category_id' => 2,
                'product_id' => 118,
            ],
        ];
        $this->table('product_categories')->insert($productCategories)->save();
    }
}
