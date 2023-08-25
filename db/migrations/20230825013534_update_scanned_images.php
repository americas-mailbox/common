<?php
declare(strict_types=1);

use Phinx\Db\Adapter\MysqlAdapter;
use Phinx\Migration\AbstractMigration;

final class UpdateScannedImages extends AbstractMigration
{
    public function change(): void
    {
        $this->table('scanned_images')
            ->addColumn('deleted', 'boolean', ['default' => 0, 'limit' => MysqlAdapter::INT_TINY])
            ->update();
    }
}
