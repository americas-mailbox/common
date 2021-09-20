<?php
declare(strict_types=1);

use Phinx\Migration\AbstractMigration;

final class UpdateAdminUsersTable extends AbstractMigration
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
        $this->table('admin_password_reset')
            ->renameColumn('user_id', 'auth_lookup_id')
            ->update();

        $this->table('admin_users')
            ->rename('admin_auth_lookups')
            ->renameColumn('person_id', 'user_id')
            ->update();
    }
}
