<?php

use Phinx\Migration\AbstractMigration;

class RenameActivityLogTable extends AbstractMigration
{
    public function up()
    {
        $table = $this->table('activity_log');
        $table
            ->rename('activity_logs')
            ->save();
    }

    public function down()
    {
        $table = $this->table('activity_logs');
        $table
            ->rename('activity_log')
            ->save();
    }
}
