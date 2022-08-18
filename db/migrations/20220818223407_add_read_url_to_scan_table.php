<?php
declare(strict_types=1);

use Phinx\Migration\AbstractMigration;

final class AddReadUrlToScanTable extends AbstractMigration
{
    public function change(): void
    {
        $this->table('scans')
            ->addColumn('read_url', 'text', ['null' => true])
            ->update();
    }
}
