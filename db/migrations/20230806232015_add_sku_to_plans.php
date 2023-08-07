<?php
declare(strict_types=1);

use Phinx\Migration\AbstractMigration;

final class AddSkuToPlans extends AbstractMigration
{
    public function change(): void
    {
        $this->table('rates_and_plans')
            ->addColumn('sku', 'char', [
                'limit' => 255,
                'null'  => true,
            ])
            ->update();
        $this->getQueryBuilder()
            ->update('rates_and_plans')
            ->set('sku', 'BRON_01')
            ->where(['id' => 1])
            ->execute();
        $this->getQueryBuilder()
            ->update('rates_and_plans')
            ->set('sku', 'GOLD_01')
            ->where(['id' => 2])
            ->execute();
        $this->getQueryBuilder()
            ->update('rates_and_plans')
            ->set('sku', 'SILV_01')
            ->where(['id' => 3])
            ->execute();
        $this->getQueryBuilder()
            ->update('rates_and_plans')
            ->set('sku', 'PLAT_01')
            ->where(['id' => 4])
            ->execute();
        $this->getQueryBuilder()
            ->update('rates_and_plans')
            ->set('sku', 'TITANIUM_PLUS')
            ->where(['id' => 6])
            ->execute();
        $this->getQueryBuilder()
            ->update('rates_and_plans')
            ->set('sku', 'QTLY_TITAN_PLUS')
            ->where(['id' => 8])
            ->execute();
    }

}
