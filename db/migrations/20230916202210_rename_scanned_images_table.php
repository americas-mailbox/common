<?php
declare(strict_types=1);

use Phinx\Migration\AbstractMigration;

final class RenameScannedImagesTable extends AbstractMigration
{
    public function up()
    {
        $table = $this->table('scanned_images');
        $table
            ->rename('parcel_images')
            ->save();
    }

    public function down()
    {
        $table = $this->table('parcel_images');
        $table
            ->rename('scanned_images')
            ->save();
    }
}
