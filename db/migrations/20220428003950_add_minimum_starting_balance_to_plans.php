<?php
declare(strict_types=1);

use Phinx\Migration\AbstractMigration;

final class AddMinimumStartingBalanceToPlans extends AbstractMigration
{
    public function change(): void
    {
        $this->table('rates_and_plans')
            ->addColumn('minimum_starting_balance', 'json')
            ->update();
        $this->getQueryBuilder()
            ->update('rates_and_plans')
            ->set('minimum_starting_balance', '{"amount": 10000, "currency": "USD"}')
            ->execute();
    }
}
