<?php
declare(strict_types=1);

use Phinx\Migration\AbstractMigration;

final class UpdateOnsInParcels extends AbstractMigration
{
    public function change(): void
    {
        $this->table('parcels')
            ->addColumn('discarded_on', 'date', ['default' => null, 'null' => true])
            ->changeColumn('finished_on', 'date', ['default' => null, 'null' => true])
            ->changeColumn('scanned_on', 'date', ['default' => null, 'null' => true])
            ->changeColumn('shredded_on', 'date', ['default' => null, 'null' => true])
            ->update();
    }
}
