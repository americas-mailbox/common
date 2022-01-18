<?php
declare(strict_types=1);

use Phinx\Migration\AbstractMigration;

final class UpdateMembershipIdColumnInAuthLookups extends AbstractMigration
{
    public function change(): void
    {
        $this->table('auth_lookups')
            ->renameColumn('membership_id', 'user_id')
            ->update();
    }
}
