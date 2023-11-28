<?php
declare(strict_types=1);

use Phinx\Db\Adapter\MysqlAdapter;
use Phinx\Migration\AbstractMigration;

final class AddNotificationColumnsToParcels extends AbstractMigration
{
    public function change(): void
    {
        $this->table('parcels')
            ->addColumn('notification_sent', 'integer', ['limit' => MysqlAdapter::INT_TINY, 'default' => 0])
            ->update();
    }
}
