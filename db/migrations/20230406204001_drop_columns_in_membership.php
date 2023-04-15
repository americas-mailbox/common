<?php
declare(strict_types=1);

use Phinx\Migration\AbstractMigration;

final class DropColumnsInMembership extends AbstractMigration
{
    public function change(): void
    {
        $table = $this->table('memberships');
        $table
            ->removeColumn('alt_email')
            ->removeColumn('alt_phone')
            ->removeColumn('email')
            ->removeColumn('first_name')
            ->removeColumn('middle_name')
            ->removeColumn('last_name')
            ->removeColumn('suffix')
            ->removeColumn('lastlogin')
            ->removeColumn('lastlogout')
            ->removeColumn('lastactivity')
            ->removeColumn('lastlogin_ip')
            ->removeColumn('lastlogin_date')
            ->removeColumn('phone')
            ->removeColumn('alternate_name')
            ->save();
    }
}
