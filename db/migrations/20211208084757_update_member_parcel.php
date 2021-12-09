<?php
declare(strict_types=1);

use Phinx\Migration\AbstractMigration;
use AMB\Entity\MemberParcelType;

final class UpdateMemberParcel extends AbstractMigration
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
            ->changeColumn('archived_on', 'date', ['default' => null, 'null' => true])
            ->addColumn('scan_id', 'integer', ['null' => true])
            ->addForeignKey('scan_id', 'scan', 'id', ['delete'=> 'SET_NULL', 'update'=> 'NO_ACTION'])
            ->changeColumn('deleted_on', 'date', ['default' => null, 'null' => true])
            ->changeColumn('first_action_taken_on', 'date', ['default' => null, 'null' => true])
            ->changeColumn('scanned_on', 'date', ['default' => null, 'null' => true])
            ->changeColumn('member_id', 'integer', ['default' => null, 'null' => true])
            ->changeColumn('scanned_by_id', 'integer', ['default' => null, 'null' => true])
            ->changeColumn('shredded_on', 'integer', ['default' => null, 'null' => true])
            ->changeColumn('shredded_by_id', 'integer', ['default' => null, 'null' => true])
            ->changeColumn('parcel_state', 'enum', ['values' => [
                'SCANNABLE',
                'QUEUED_FOR_SCAN',
                'QUEUED_FOR_DISPOSAL',
                'DISPOSABLE',
                'SCANNED',
                'ARCHIVABLE',
            ],'default' => 'SCANNABLE'])
            ->save();
    }
}
