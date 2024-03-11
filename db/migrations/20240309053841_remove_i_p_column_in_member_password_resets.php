<?php
declare(strict_types=1);

use Phinx\Migration\AbstractMigration;

final class RemoveIPColumnInMemberPasswordResets extends AbstractMigration
{
    public function change(): void
    {
        $this->table('member_password_resets')
            ->removeColumn('ip_address')
            ->update();
    }
}
