<?php
declare(strict_types=1);

use Phinx\Migration\AbstractMigration;

final class RemoveFileIdColumnFromParcelImages extends AbstractMigration
{
    public function change(): void
    {
        $this->table('parcel_images')
            ->removeColumn('file_id')
            ->update();
    }
}
