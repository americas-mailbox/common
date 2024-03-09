<?php
declare(strict_types=1);

use Phinx\Migration\AbstractMigration;

final class RenameMemberPasswordReset extends AbstractMigration
{
    public function up()
    {
        $table = $this->table('member_password_reset');
        $table
            ->rename('member_password_resets')
            ->save();
    }

    public function down()
    {
        $table = $this->table('member_password_resets');
        $table
            ->rename('member_password_reset')
            ->save();
    }
}
