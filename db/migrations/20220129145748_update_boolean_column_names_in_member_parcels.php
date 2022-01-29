<?php
declare(strict_types=1);

use Phinx\Migration\AbstractMigration;

final class UpdateBooleanColumnNamesInMemberParcels extends AbstractMigration
{
    public function change(): void
    {
        $this->table('member_parcels')
            ->renameColumn('archived', 'is_archived')
            ->renameColumn('deleted', 'is_deleted')
            ->renameColumn('important', 'is_important')
            ->update();
    }
}
