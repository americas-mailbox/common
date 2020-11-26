<?php
declare(strict_types=1);

use Phinx\Migration\AbstractMigration;

final class UpdateRegisteredAgentPrice extends AbstractMigration
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
        $this->getQueryBuilder()
            ->update('products')
            ->set('price', '{"amount":5000,"currency":"USD"}')
            ->where(['name' => 'REG_AGT'])
            ->execute();
    }
}
