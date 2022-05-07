<?php
declare(strict_types=1);

use Phinx\Migration\AbstractMigration;

final class AddStartingSkuToPlan extends AbstractMigration
{
    public function change(): void
    {
        $this->table('rates_and_plans')
            ->addColumn('starting_sku', 'char', [
                'limit' => 255,
                'null'  => true,
            ])
            ->update();
        $this->getQueryBuilder()
            ->update('rates_and_plans')
            ->set('starting_sku', 'NEW_BRON_01')
            ->where(['id' => 1])
            ->execute();
        $this->getQueryBuilder()
            ->update('rates_and_plans')
            ->set('starting_sku', 'NEW_GOLD_01')
            ->where(['id' => 2])
            ->execute();
        $this->getQueryBuilder()
            ->update('rates_and_plans')
            ->set('starting_sku', 'NEW_SILV_01')
            ->where(['id' => 3])
            ->execute();
        $this->getQueryBuilder()
            ->update('rates_and_plans')
            ->set('starting_sku', 'NEW_PLAT_01')
            ->where(['id' => 4])
            ->execute();
        $this->getQueryBuilder()
            ->update('rates_and_plans')
            ->set('starting_sku', 'NEW_TIT_PLUS_01')
            ->where(['id' => 6])
            ->execute();
        $this->getQueryBuilder()
            ->update('rates_and_plans')
            ->set('starting_sku', 'NEW_TIT_QTLY_01')
            ->where(['id' => 8])
            ->execute();
    }
}
