<?php
declare(strict_types=1);

use Phinx\Migration\AbstractMigration;

final class UpdateScannedPages extends AbstractMigration
{
    public function change(): void
    {
        $this->table('scanned_pages')
            ->addColumn('scanned_by_id', 'char', ['limit' => '255'])
            ->addColumn('scanned_by_role', 'char', ['limit' => '255'])
            ->update();
    }
}
