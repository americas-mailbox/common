<?php
declare(strict_types=1);

use Phinx\Migration\AbstractMigration;

final class DropMoreColumnsInMembership extends AbstractMigration
{
    public function change()
    {
        $this->table('memberships')
            ->removeColumn('next_renewal_date')
            ->removeColumn('plan_id')
            ->removeColumn('renewal_frequency')
            ->save();
    }
}
