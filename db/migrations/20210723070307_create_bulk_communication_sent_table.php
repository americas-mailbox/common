<?php
declare(strict_types=1);

use Phinx\Migration\AbstractMigration;

final class CreateBulkCommunicationSentTable extends AbstractMigration
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
        $this->table('bulk_communication_sent', ['id' => false])
            ->addColumn('bulk_communication_id', 'integer', ['signed' => false])
            ->addColumn('member_id', 'integer', ['signed' => false])
            ->addTimestamps()
            ->create();
    }
}
