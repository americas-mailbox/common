<?php
declare(strict_types=1);

use Phinx\Db\Adapter\MysqlAdapter;
use Phinx\Migration\AbstractMigration;

final class PutShippingEventDataInSingleTable extends AbstractMigration
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
        $this->table('shipping_events')
            ->addColumn('daily', 'integer', [
                'limit' => MysqlAdapter::INT_TINY,
                'signed' => false,
                'default' => 0,
            ])
            ->addColumn('day_of_the_month', 'integer', [
                'limit' => MysqlAdapter::INT_TINY,
                'signed' => false,
                'null' => true,
            ])
            ->addColumn('day_of_the_week', 'integer', [
                'limit' => MysqlAdapter::INT_TINY,
                'signed' => false,
                'null' => true,
            ])
            ->addColumn('first_weekday_of_the_month', 'integer', [
                'limit' => MysqlAdapter::INT_TINY,
                'signed' => false,
                'null' => true,
            ])
            ->addColumn('last_weekday_of_the_month', 'integer', [
                'limit' => MysqlAdapter::INT_TINY,
                'signed' => false,
                'null' => true,
            ])
            ->addColumn('next_weekly', 'date', ['null' => true])
            ->addColumn('weeks_between', 'integer', [
                'limit' => MysqlAdapter::INT_TINY,
                'signed' => false,
                'null' => true,
            ])
            ->addColumn('recurrence_type', 'char', [
                'limit' => 25,
            ])
            ->update();
    }
}
