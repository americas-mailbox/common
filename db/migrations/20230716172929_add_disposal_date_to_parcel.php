<?php
declare(strict_types=1);

use Phinx\Migration\AbstractMigration;

final class AddDisposalDateToParcel extends AbstractMigration
{
    public function change(): void
    {
        $this->table('parcels')
            ->addColumn('dispose_on', 'date', ['null' => true])
            ->update();
    }
}
