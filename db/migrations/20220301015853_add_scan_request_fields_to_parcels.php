<?php
declare(strict_types=1);

use Phinx\Migration\AbstractMigration;

final class AddScanRequestFieldsToParcels extends AbstractMigration
{
    public function change(): void
    {
        $this->table('parcels')
            ->addColumn('follow_up_action', 'enum', [
                'values' => [
                    'QUEUED_FOR_DISCARDING',
                    'QUEUED_FOR_SHIPPING',
                    'QUEUED_FOR_SHREDDING',
                ],
                'null' => true,
                'default' => null])
            ->addColumn('additional_scanning_info', 'char', [
                'limit' => 255,
                'null' => true,
            ])
            ->update();
    }
}
