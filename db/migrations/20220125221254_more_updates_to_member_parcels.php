<?php
declare(strict_types=1);

use Phinx\Migration\AbstractMigration;

final class MoreUpdatesToMemberParcels extends AbstractMigration
{
    public function change(): void
    {
        $this->table('member_parcels')
//            ->changeColumn('discarded_by_id', 'integer', ['default' => null, 'null' => true])
            ->changeColumn('finished_on', 'integer', ['default' => null, 'null' => true])
            ->update();
    }
}
