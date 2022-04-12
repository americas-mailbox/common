<?php
declare(strict_types=1);

use Phinx\Migration\AbstractMigration;

final class AddNeedsPMBToParcelState extends AbstractMigration
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
        $this->table('parcels')
            ->changeColumn('parcel_state', 'enum', ['values' => [
                'DISCARDED',
                'NEEDS_PMB',
                'QUEUED_FOR_DISCARDING',
                'QUEUED_FOR_SCAN',
                'QUEUED_FOR_SHREDDING',
                'SCANNABLE',
                'SCANNED',
                'SHIPPED',
                'SHREDDED',
                'UNSCANNABLE',
            ],'default' => 'NEEDS_PMB'])
            ->update();
    }
}
