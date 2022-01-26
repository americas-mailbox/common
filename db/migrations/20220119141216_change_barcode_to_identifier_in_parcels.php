<?php
declare(strict_types=1);

use Phinx\Migration\AbstractMigration;

final class ChangeBarcodeToIdentifierInParcels extends AbstractMigration
{
    public function change(): void
    {
        $this->table('parcels')
            ->renameColumn('barcode', 'identifier')
            ->update();
    }
}
