<?php
declare(strict_types=1);

use Phinx\Db\Adapter\MysqlAdapter;
use Phinx\Migration\AbstractMigration;

final class AddProcessingFlagToScannedImages extends AbstractMigration
{
    public function change(): void
    {
        $this->table('scanned_images')
            ->addColumn('is_processing', 'integer', ['limit' => MysqlAdapter::INT_TINY, 'default' => 0])
            ->update();
    }
}
