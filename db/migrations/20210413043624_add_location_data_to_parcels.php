<?php
declare(strict_types=1);

use Phinx\Db\Adapter\MysqlAdapter;
use Phinx\Migration\AbstractMigration;

final class AddLocationDataToParcels extends AbstractMigration
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
            ->addColumn('located_by_id', 'integer', [
                'limit' => MysqlAdapter::INT_REGULAR,
                'signed' => false,
                'null' => true,
            ])
            ->addColumn('located_on', 'date', ['null' => true])
            ->addColumn('location_id', 'integer', [
                'limit' => MysqlAdapter::INT_REGULAR,
                'signed' => false,
                'null' => true,
            ])
            ->update();
    }
}
