<?php
declare(strict_types=1);

use Phinx\Migration\AbstractMigration;

final class SetMissingExtensionPlans extends AbstractMigration
{
    public function change(): void
    {
        $productCategories = [
            [
                'category_id' => 5,
                'product_id'  => 4,
            ],
            [
                'category_id' => 5,
                'product_id'  => 5,
            ],
            [
                'category_id' => 5,
                'product_id'  => 6,
            ],
            [
                'category_id' => 5,
                'product_id'  => 7,
            ],
        ];
        $this->table('product_categories')->insert($productCategories)->save();
    }
}
