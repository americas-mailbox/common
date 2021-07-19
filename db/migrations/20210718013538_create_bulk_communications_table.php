<?php
declare(strict_types=1);

use Phinx\Migration\AbstractMigration;

final class CreateBulkCommunicationsTable extends AbstractMigration
{
    /**
     * Change Method.
     *
     * Write your reversible migrations using this method.
     *
     * More information on writing migrations is available here:
     * https://book.cakephp.org/phinx/0/en/migrations.html#the-change-method
     *
     * Remember to call "create()" or "update()" and NOT "save()" when working
     * with the Table class.
     */
    public function change(): void
    {
        $this->table('bulk_communications')
            ->addColumn('email_body', 'text', [
                'null'  => true,
            ])
            ->addColumn('scheduled_for', 'datetime')
            ->addColumn('send_options', 'json')
            ->addColumn('sms_body', 'text', [
                'null'  => true,
            ])
            ->addColumn('subject', 'char', [
                'limit' => 255,
                'null'  => true,
            ])
            ->addColumn('title', 'char', [
                'limit' => 255,
                'null'  => true,
            ])
            ->addTimestamps()
            ->create();
    }
}
