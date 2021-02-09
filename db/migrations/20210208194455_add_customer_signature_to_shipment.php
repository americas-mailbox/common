<?php
declare(strict_types=1);

use Phinx\Migration\AbstractMigration;

final class AddCustomerSignatureToShipment extends AbstractMigration
{
    public function change(): void
    {
        $this->table('shipments')
            ->addColumn('customer_signature_url', 'char', [
                'null' => true,
                'limit' => 255,
            ])
            ->update();
    }
}
