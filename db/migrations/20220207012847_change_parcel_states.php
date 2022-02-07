<?php
declare(strict_types=1);

use Phinx\Migration\AbstractMigration;

final class ChangeParcelStates extends AbstractMigration
{
    public function change(): void
    {
        $this->table('parcels')
            ->changeColumn('parcel_state', 'enum', ['values' => [
                'ARCHIVABLE',
                'DISCARDABLE',
                'QUEUED_FOR_DISCARDING',
                'QUEUED_FOR_SCAN',
                'QUEUED_FOR_SHREDDING',
                'SCANNABLE',
                'SCANNED',
                'TO_BE_SHIPPED',
            ],'default' => 'TO_BE_SHIPPED'])
            ->update();
    }
}
