<?php
declare(strict_types=1);

use Phinx\Migration\AbstractMigration;

final class RenameIdColumnInScannedImages extends AbstractMigration
{
    public function change(): void
    {
        $scannedImages = $this->table('scanned_images');
        $scannedImages
            ->renameColumn('id', 'file_id')
            ->changePrimaryKey(null)
            ->update();
        $sql = <<<SQL
alter table scanned_images 
    drop primary key;

alter table scanned_images
    add id int;

create unique index scanned_images_id_uindex
    on scanned_images (id);

alter table scanned_images
    modify id int auto_increment;

alter table scanned_images
    add constraint scanned_images_pk
        primary key (id);
SQL;
        $this->execute($sql);
    }
}
