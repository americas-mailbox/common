<?php
declare(strict_types=1);

use Phinx\Migration\AbstractMigration;

final class RemoveFileIdColumnFromScannedPages extends AbstractMigration
{
    public function change(): void
    {
        $this->table('scanned_pages')
            ->removeColumn('file_id')
            ->update();
    }
}
