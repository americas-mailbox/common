<?php
declare(strict_types=1);

use Phinx\Migration\AbstractMigration;

final class UpdateParcelStatesInParcels extends AbstractMigration
{
    public function change(): void
    {
        $this->table('parcels')
            ->changeColumn('parcel_state', 'enum', ['values' => [
                'DISCARDED',
                'NEEDS_PMB',
                'QUEUED_FOR_DISCARDING',
                'QUEUED_FOR_SCAN_AND_DISCARDING',
                'QUEUED_FOR_SCAN_AND_SHREDDING',
                'QUEUED_FOR_SCAN_AND_SHIPPING',
                'QUEUED_FOR_SHIPPING',
                'QUEUED_FOR_SHREDDING',
                'SCANNABLE',
                'SCANNED_AND_DISCARDED',
                'SCANNED_AND_QUEUED_FOR_DISCARDING',
                'SCANNED_AND_QUEUED_FOR_SHIPPING',
                'SCANNED_AND_QUEUED_FOR_SHREDDING',
                'SCANNED_AND_SHIPPED',
                'SCANNED_AND_SHREDDED',
                'SHIPPED',
                'SHREDDED',
                'UNSCANNABLE',
            ],'default' => 'NEEDS_PMB'])
            ->update();
    }
}
