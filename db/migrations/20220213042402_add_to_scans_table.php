<?php
declare(strict_types=1);

use Phinx\Migration\AbstractMigration;

final class AddToScansTable extends AbstractMigration
{
    public function change(): void
    {
        $this->table('scans')
            ->addColumn('pages', 'integer')
            ->addColumn('scanned_at', 'timestamp')
            ->addColumn('scanned_by_id', 'integer')
            ->update();
    }
}
