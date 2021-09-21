<?php
declare(strict_types=1);

use Phinx\Migration\AbstractMigration;

final class UpdateShippingMethodTable extends AbstractMigration
{
    public function change(): void
    {
        $this->table('delivery_methods')
            ->addColumn('internal_label', 'char', [
                'null' => true,
                'limit' => 255,
            ])
            ->addColumn('internal_short_label', 'char', [
                'null' => true,
                'limit' => 10,
            ])
            ->update();
    }
}
