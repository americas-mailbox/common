<?php
declare(strict_types=1);

use Phinx\Migration\AbstractMigration;

final class UpdateUsernameIndexInMemberAuthLookups extends AbstractMigration
{
    public function change(): void
    {
        $this->table('member_auth_lookups')->removeIndexByName('username')->save();
        $this->table('member_auth_lookups')
            ->addIndex('username', ['unique' => false,])
            ->save();
    }
}
