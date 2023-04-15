<?php
declare(strict_types=1);

use Phinx\Migration\AbstractMigration;

final class DropUnneededMembershipStatusColumns extends AbstractMigration
{
    public function change(): void
    {
        $table = $this->table('memberships');
        $table
            ->removeColumn('active')
            ->removeColumn('lead')
            ->removeColumn('old_status')
            ->removeColumn('suspended')
            ->save();
    }
}
