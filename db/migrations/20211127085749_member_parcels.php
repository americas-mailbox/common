<?php
declare(strict_types=1);

use Phinx\Migration\AbstractMigration;
use Phinx\Db\Adapter\MysqlAdapter;

final class MemberParcels extends AbstractMigration
{
    /**
     * Change Method.
     *
     * Write your reversible migrations using this method.
     *
     * More information on writing migrations is available here:
     * https://book.cakephp.org/phinx/0/en/migrations.html#the-change-method
     *
     * Remember to call "create()" or "update()" and NOT "save()" when working
     * with the Table class.
     */
    public function change(): void
    {

        $this->table('member_parcels')
            ->addColumn('archived', 'boolean',['default' => 0, 'limit' => MysqlAdapter::INT_TINY])
            ->addColumn('archived_on', 'date', ['default' => null, 'null' => true])
            ->addColumn('deleted', 'boolean', ['default' => 0, 'limit' => MysqlAdapter::INT_TINY])
            ->addColumn('deleted_on', 'date', ['default' => null, 'null' => true])
            ->addColumn('discarded_by_id', 'integer', ['default' => null])
            ->addColumn('finished_on', 'date', ['default' => null])
            ->addColumn('first_action_taken_on', 'date', ['default' => null, 'null' => true])
            ->addColumn('important', 'boolean', ['default' => 0, 'limit' => MysqlAdapter::INT_TINY])
            ->addColumn('member_id', 'integer', ['default' => null, 'null' => true])
            ->addColumn('parcel_id', 'integer', ['null' => true])
            ->addForeignKey('parcel_id', 'parcels', 'id', ['delete'=> 'SET_NULL', 'update'=> 'NO_ACTION'])
            ->addColumn('parcel_state', 'enum', ['values' => ['0', '1'],'null' => 0])
            ->addColumn('scanned_on', 'date', ['default' => null, 'null' => true])
            ->addColumn('scanned_by_id', 'integer', ['default' => null, 'null' => true])
            ->addColumn('shredded_on', 'date', ['default' => null, 'null' => true])
            ->addColumn('shredded_by_id', 'integer', ['default' => null, 'null' => true])
            ->addTimestamps()
            ->create();
    }
}
