<?php
declare(strict_types=1);

use Phinx\Db\Adapter\MysqlAdapter;
use Phinx\Migration\AbstractMigration;

final class CreateParcelsTable extends AbstractMigration
{
    public function change(): void
    {
        $this->table('parcels')
            ->addColumn('back_image_file', 'char', [
                'limit' => 255,
                'null'  => true,
            ])
            ->addColumn('barcode', 'char', [
                'limit' => 25,
                'null'  => true,
            ])
            ->addColumn('entered_by_id', 'integer', ['limit' => MysqlAdapter::INT_REGULAR, 'signed' => false])
            ->addColumn('entered_on', 'date')
            ->addColumn('front_image_file', 'char', [
                'limit' => 255,
                'null'  => true,
            ])
            ->addColumn('pmb', 'char', [
                'limit' => 10,
                'null'  => true,
            ])
            ->addColumn('shipment_id', 'integer', ['limit' => MysqlAdapter::INT_REGULAR, 'signed' => false])
            ->addColumn('thumbnail_file', 'char', [
                'limit' => 255,
                'null'  => true,
            ])
            ->addTimestamps()
            ->create();
    }
}
