<?php
declare(strict_types=1);

use Phinx\Migration\AbstractMigration;

final class InteriorScanSKUS extends AbstractMigration
{
    public function change(): void
    {
        $sku = [
            [
                'id'          => 151,
                'description' => 'Additional page',
                'name'        => 'CONTENT_ADDITIONAL_PAGE',
                'price'       => '{"amount":100,"currency":"USD"}',
                'taxable'     => 1,
                'active'      => 1,
            ],
        ];
        $this->table('products')->insert($sku)->save();

        $productCategories = [
            [
                'category_id' => 2,
                'product_id'  => 151,
            ],
        ];
        $this->table('product_categories')->insert($productCategories)->save();

        $this->getQueryBuilder()
            ->update('products')
            ->set('description', 'Interior Scan')
            ->where(['name' => 'CONTENT_SCAN'])
            ->execute();
    }
}
