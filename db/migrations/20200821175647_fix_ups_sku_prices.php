<?php
declare(strict_types=1);

use Phinx\Migration\AbstractMigration;

final class FixUpsSkuPrices extends AbstractMigration
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
            ->set('price', '{"amount":110,"currency":"USD"}')
            ->where(['name' => 'UPS_GROUND'])
            ->execute();
        $this->getQueryBuilder()
            ->update('products')
            ->set('price', '{"amount":110,"currency":"USD"}')
            ->where(['name' => 'UPS_NEXT_DAY_AIR'])
            ->execute();
        $this->getQueryBuilder()
            ->update('products')
            ->set('price', '{"amount":110,"currency":"USD"}')
            ->where(['name' => 'UPS_2ND_DAY_AIR'])
            ->execute();
        $this->getQueryBuilder()
            ->update('products')
            ->set('price', '{"amount":110,"currency":"USD"}')
            ->where(['name' => 'UPS_3_DAY_SELECT'])
            ->execute();
    }
}
