<?php
declare(strict_types=1);

use Phinx\Migration\AbstractMigration;

final class AddRatioToImages extends AbstractMigration
{
    public function change(): void
    {
        $this->table('images')
            ->addColumn('ratio', 'decimal', [
                'precision' => 17,
                'scale' => 15,
            ])
            ->update();
        $this->table('scanned_images')
            ->addColumn('ratio', 'decimal', [
                'precision' => 17,
                'scale' => 15,
            ])
            ->update();
        $this->table('scanned_pages')
            ->addColumn('ratio', 'decimal', [
                'precision' => 17,
                'scale' => 15,
            ])
            ->update();
    }
}
