<?php
declare(strict_types=1);

use Phinx\Migration\AbstractMigration;

final class RenameMembersToMembership extends AbstractMigration
{
    public function change(): void
    {
        $table = $this->table('members');
        $table
            ->rename('memberships')
            ->update();
    }
}
