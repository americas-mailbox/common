<?php
declare(strict_types=1);

use Phinx\Db\Adapter\MysqlAdapter;
use Phinx\Migration\AbstractMigration;

final class FoldMemberParcelIntoParcel extends AbstractMigration
{
    public function change(): void
    {
        $this->table('parcels')
            ->addColumn('archived_on', 'date', ['default' => null, 'null' => true])
            ->addColumn('deleted_on', 'date', ['default' => null, 'null' => true])
            ->addColumn('discarded_by_id', 'integer', ['default' => null, 'null' => true])
            ->addColumn('first_action_taken_on', 'date', ['default' => null, 'null' => true])
            ->addColumn('finished_on', 'date', ['default' => null, 'null' => true])
            ->addColumn('is_archived', 'boolean',['default' => 0, 'limit' => MysqlAdapter::INT_TINY])
            ->addColumn('is_deleted', 'boolean', ['default' => 0, 'limit' => MysqlAdapter::INT_TINY])
            ->addColumn('is_important', 'boolean', ['default' => 0, 'limit' => MysqlAdapter::INT_TINY])
            ->addColumn('parcel_state', 'enum', ['values' => [
                'ARCHIVABLE',
                'DISPOSABLE',
                'QUEUED_FOR_SCAN',
                'QUEUED_FOR_DISPOSAL',
                'QUEUED_FOR_SHREDDING',
                'SCANNED',
                'SCANNABLE',
                'TO_BE_SHIPPED',
            ],'default' => 'TO_BE_SHIPPED'])
            ->addColumn('scan_id', 'integer', ['null' => true])
            ->addForeignKey('scan_id', 'scans', 'id')
            ->addColumn('scanned_on', 'date', ['default' => null, 'null' => true])
            ->addColumn('scanned_by_id', 'integer', ['default' => null, 'null' => true])
            ->addColumn('shredded_on', 'integer', ['default' => null, 'null' => true])
            ->addColumn('shredded_by_id', 'integer', ['default' => null, 'null' => true])
            ->update();
    }
}
