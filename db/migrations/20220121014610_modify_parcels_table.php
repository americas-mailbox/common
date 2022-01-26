<?php
declare(strict_types=1);

use Phinx\Migration\AbstractMigration;

final class ModifyParcelsTable extends AbstractMigration
{
    public function change(): void
    {
        $this->table('parcels')
            ->addColumn('images', 'json')
            ->removeColumn('back_image_file', 'user_id')
            ->removeColumn('front_image_file', 'user_id')
            ->removeColumn('thumbnail_file', 'user_id')
            ->addIndex('identifier', ['unique' => true])
            ->update();
    }
}
