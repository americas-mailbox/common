<?php


use Phinx\Seed\AbstractSeed;

class ShipmentMethodSeeder extends AbstractSeed
{
    /**
     * Run Method.
     *
     * Write your database seeder using this method.
     *
     * More information on writing seeders is available here:
     * http://docs.phinx.org/en/latest/seeding.html
     */
    public function run()
    {
        $data = [
            [
                'label'    => 'Air Cargo - 2nd Day Air',
                'group' => 'shipping',
                'weight' => 2,
                'active' => 1,
            ],
            [
                'label'    => 'Air Cargo - 3rd Day Air',
                'group' => 'shipping',
                'weight' => 2,
                'active' => 1,
            ],
            [
                'label'    => 'Air Cargo - Ground',
                'group' => 'shipping',
                'weight' => 2,
                'active' => 1,
            ],
            [
                'label'    => 'Air Cargo - Overnight',
                'group' => 'shipping',
                'weight' => 2,
                'active' => 1,
            ],
            [
                'label'    => 'Best Method',
                'group' => 'shipping',
                'weight' => 1,
                'active' => 1,
            ],
            [
                'label'    => 'Best Method - International',
                'group' => 'international',
                'weight' => 1,
                'active' => 1,
            ],
            [
                'label'    => 'Customer Pick Up',
                'group' => 'pickup',
                'weight' => 1,
                'active' => 1,
            ],
            [
                'label'    => 'FedEx - 2nd Day Air',
                'group' => 'shipping',
                'weight' => 2,
                'active' => 1,
            ],
            [
                'label'    => 'FedEx - 3rd Day Air',
                'group' => 'shipping',
                'weight' => 2,
                'active' => 1,
            ],
            [
                'label'    => 'FedEx - Ground',
                'group' => 'shipping',
                'weight' => 2,
                'active' => 1,
            ],
            [
                'label'    => 'FedEx - International',
                'group' => 'international',
                'weight' => 2,
                'active' => 1,
            ],
            [
                'label'    => 'FedEx - Overnight',
                'group' => 'shipping',
                'weight' => 2,
                'active' => 1,
            ],
            [
                'label'    => 'UPS - Overnight',
                'group' => 'shipping',
                'weight' => 2,
                'active' => 0,
            ],
            [
                'label'    => 'US Postal Service - Express 2 Day Service',
                'group' => 'shipping',
                'weight' => 2,
                'active' => 1,
            ],
            [
                'label'    => 'US Postal Service - First Class (if available)',
                'group' => 'shipping',
                'weight' => 2,
                'active' => 1,
            ],
            [
                'label'    => 'US Postal Service - International',
                'group' => 'international',
                'weight' => 2,
                'active' => 1,
            ],
            [
                'label'    => 'US Postal Service - Priority Only',
                'group' => 'shipping',
                'active' => 1,
                'weight' => 2,
            ],
            [
                'label'    => 'FedEx - 2nd Day',
                'group' => 'shipping',
                'weight' => 2,
                'active' => 0,
            ],
            [
                'label'    => 'DHL - Overnight',
                'group' => 'shipping',
                'weight' => 2,
                'active' => 0,
            ],
        ];

        $shipmentMethods = $this->table('delivery_methods');
        $shipmentMethods
            ->insert($data)
            ->save();
    }
}
