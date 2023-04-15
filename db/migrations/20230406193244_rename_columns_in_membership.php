<?php
declare(strict_types=1);

use Phinx\Migration\AbstractMigration;

final class RenameColumnsInMembership extends AbstractMigration
{
    public function change(): void
    {
        $this->table('memberships')
            ->renameColumn('member_id', 'id')
            ->renameColumn('level_id', 'plan_id')
            ->renameColumn('startDate', 'join_date')
            ->renameColumn('renewDate', 'next_renewal_date')
            ->renameColumn('shipinst', 'shipping_instructions')
            ->save();
    }
}
