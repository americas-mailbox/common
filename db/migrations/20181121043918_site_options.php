<?php


use Phinx\Migration\AbstractMigration;

class SiteOptions extends AbstractMigration
{
    public function change()
    {
        $table = $this->table('site_options', ['id' => false]);
        $table
            ->addColumn('data', 'text')
            ->create();
    }
}
