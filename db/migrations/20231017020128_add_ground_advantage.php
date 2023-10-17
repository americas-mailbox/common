<?php
declare(strict_types=1);

use Phinx\Migration\AbstractMigration;

final class AddGroundAdvantage extends AbstractMigration
{
    public function change(): void
    {
        $deliveryMethod = [
            'active'               => 1,
            'company_id'           => 4,
            'id'                   => 25,
            'internal_label'       => 'USPS Ground Advantage',
            'internal_short_label' => 'USPS ADV',
            'label'                => 'Ground Advantage',
            'group'                => 'shipping',
            'weight'               => 2,
        ];
        $this->table('delivery_methods')->insert($deliveryMethod)->save();

        $serviceData = [
            'delivery_method_id' => 25,
            'service_code'       => 'usps_ground_advantage',
        ];
        $this->table('delivery_methods_services')->insert($serviceData)->save();

        $product = [
            'id' => 143,
            'active' => 1,
            'description' => "USPS Ground Advantage",
            'name' => 'USPS_GND_ADV',
            'price' => '{"amount":135,"currency":"USD"}',
            'taxable' => 1,
        ];
        $this->table('products')->insert($product)->save();
        $category = [
            'category_id' => 2,
            'product_id' => 143
        ];
    }
}
