<?php
declare(strict_types=1);

use Phinx\Migration\AbstractMigration;

final class AddMembershipIdToScan extends AbstractMigration
{

    public function change(): void
    {
        $this->table('scans')
            ->addColumn('membership_id', 'integer')
            ->update();
    }
}
