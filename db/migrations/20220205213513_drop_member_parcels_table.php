<?php
declare(strict_types=1);

use Phinx\Migration\AbstractMigration;

final class DropMemberParcelsTable extends AbstractMigration
{
    public function change(): void
    {
        $this->table('member_parcels')->drop()->save();
    }
}
