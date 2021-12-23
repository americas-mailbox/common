<?php
declare(strict_types=1);

use Phinx\Migration\AbstractMigration;

final class MembersTableCleanup extends AbstractMigration
{
    public function change(): void
    {
        $this->table('members')
            ->removeColumn('othernames')
            ->removeColumn('username')
            ->changeColumn('updated_at', 'timestamp', ['update' => 'CURRENT_TIMESTAMP'])
            ->update();
    }
}
