<?php
declare(strict_types=1);

use Phinx\Migration\AbstractMigration;

final class MakeUsernameNullableInMemberAuthLookup extends AbstractMigration
{
    public function change(): void
    {
        $this->table('member_auth_lookup')
            ->changeColumn('username','string', ['null' => true])
            ->save();
    }
}
