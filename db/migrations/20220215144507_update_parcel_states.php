<?php
declare(strict_types=1);

use Phinx\Migration\AbstractMigration;

final class UpdateParcelStates extends AbstractMigration
{
    public function change(): void
    {
        $this->table('parcels')
            ->changeColumn('parcel_state', 'enum', ['values' => [
                'DISCARDED',
                'QUEUED_FOR_DISCARDING',
                'QUEUED_FOR_SCAN',
                'QUEUED_FOR_SHREDDING',
                'SCANNABLE',
                'SCANNED',
                'SHIPPED',
                'SHREDDED',
                'UNSCANNABLE',
            ],'default' => 'UNSCANNABLE'])
            ->update();
    }
}
