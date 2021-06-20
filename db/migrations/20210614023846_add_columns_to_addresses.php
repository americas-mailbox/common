<?php
declare(strict_types=1);

use Phinx\Migration\AbstractMigration;

final class AddColumnsToAddresses extends AbstractMigration
{
    public function change(): void
    {
        $this->table('addresses')
            ->addColumn('in_care_of', 'char', [
                'null' => true,
                'limit' => 255,
            ])
            ->addColumn('address', 'char', [
                'limit' => 255,
            ])
            ->addColumn('location_name', 'char', [
                'null' => true,
                'limit' => 255,
            ])
            ->addColumn('suite', 'char', [
                'null' => true,
                'limit' => 255,
            ])
            ->changeColumn('street_1', 'char', [
                'null' => true,
                'limit' => 255,
            ])
            ->renameColumn('user_id', 'membership_id')
            ->addTimestamps()
            ->update();
    }
}
