<?php
declare(strict_types=1);

use Phinx\Migration\AbstractMigration;

final class PostcardsAdmin extends AbstractMigration
{
    /**
     * Migrate Up.
     */
    public function up()
    {
        $table = $this->table('postcards_batch');
        $table
            ->addColumn('pmb', 'integer')
            ->addColumn('state', 'enum',['values' => ['SUCCESS','FAILED','QUEUED', 'NOTIFIED']])
            ->addColumn('batch', 'string')
            ->addColumn('metadata', 'json')
            ->addColumn('frontface', 'string')
            ->addColumn('backface', 'string')
            ->addColumn('created_at', 'datetime', ['default' => 'CURRENT_TIMESTAMP'])
            ->addColumn('updated_at', 'datetime', ['default' => 'CURRENT_TIMESTAMP', 'update' => 'CURRENT_TIMESTAMP'])
            ->create();

        $table2 = $this->table('postcard_fees');
        $table2
            ->addColumn('postcard_id','integer',['null' => false])
            ->addForeignKey('postcard_id', 'postcards_batch', 'id', ['delete'=> 'CASCADE', 'update'=> 'NO_ACTION'])
            ->addColumn('title','string',['limit' => 100, 'null' => false])
            ->addColumn('year','string',['limit' => 20, 'null' => false])
            ->addColumn('color','string',['limit' => 100])
            ->addColumn('make','string',['limit' => 100])
            ->addColumn('fee','json', ['null' => false])
            ->addColumn('mail_fee','json', ['null' => false])
            ->addColumn('approved','boolean')
            ->addIndex(['title', 'year','color'], ['unique' => true])
            ->create();
    }

    /**
     * Migrate Down.
     */
    public function down()
    {
        $this->table('postcards_batch')->drop()->save();
        $this->table('postcards_fees')->drop()->save();
    }

}
