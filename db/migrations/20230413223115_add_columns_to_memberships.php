<?php
declare(strict_types=1);

use Phinx\Migration\AbstractMigration;

final class AddColumnsToMemberships extends AbstractMigration
{
    public function change()
    {
        $this->table('memberships')
            ->addColumn('default_address_id', 'integer', ['null' => true])
            ->addColumn(
                'office_closed_delivery',
                'char',
                [
                    'default' => 'before',
                    'limit' => 8,
                ]
            )
            ->save();
    }
}
