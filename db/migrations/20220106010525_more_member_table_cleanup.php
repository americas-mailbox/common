<?php
declare(strict_types=1);

use Phinx\Migration\AbstractMigration;

final class MoreMemberTableCleanup extends AbstractMigration
{
    public function change(): void
    {
        $this->table('members')
            ->removeColumn('need_mm_sync')
            ->removeColumn('officeid')
            ->removeColumn('photo')
            ->removeColumn('suspendedmessage')
            ->changeColumn('updated_at', 'timestamp', ['default' => 'CURRENT_TIMESTAMP', 'update' => 'CURRENT_TIMESTAMP'])
            ->update();
    }
}
