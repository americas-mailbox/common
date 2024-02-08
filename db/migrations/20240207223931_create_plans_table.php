<?php
declare(strict_types=1);

use Money\Currency;
use Money\Money;
use Phinx\Db\Adapter\MysqlAdapter;
use Phinx\Migration\AbstractMigration;

final class CreatePlansTable extends AbstractMigration
{
    public function change(): void
    {
        $table = $this->table('plans');
        $table
            ->addColumn('active', 'integer', ['limit' => MysqlAdapter::INT_TINY, 'default' => 1])
            ->addColumn('company_id', 'integer', ['signed' => false, 'null' => false])
            ->addColumn('location_id', 'integer', ['signed' => false, 'null' => true])
            ->addColumn('title', 'char')
            ->addColumn('html_color', 'char', ['null' => true])
            ->addColumn('first_line', 'char')
            ->addColumn('second_line', 'char')
            ->addColumn('third_line', 'char')
            ->addColumn('forth_line', 'char')
            ->addColumn('fifth_line', 'char')
            ->addColumn('description', 'text')
            ->addColumn('annual_price', 'json')
            ->addColumn('monthly_price', 'json')
            ->addColumn('monthly_minimum', 'integer', ['signed' => false, 'default' => 1])
            ->addColumn('set_up_fee', 'json')
            ->addColumn('minimum_starting_balance', 'json')
            ->addColumn('critical_balance', 'json')
            ->addColumn('minimum_balance', 'json')
            ->addColumn('sku_new_annual', 'text')
            ->addColumn('sku_new_monthly', 'text')
            ->addColumn('sku_renew_annual', 'text')
            ->addColumn('sku_renew_monthly', 'text')
            ->addTimestamps()
            ->create();

        $currency = new Currency('USD');
        $stmt = $this->query('SELECT * FROM rates_and_plans');
        $plans = $stmt->fetchAll();
        foreach ($plans as $plan) {
            if (in_array($plan['id'], [5,8])) {
                continue;
            }
            $amount = json_decode($plan['price'], true);
            $annual = new Money($amount['amount'], $currency);
            $perMonth = $annual->divide(12);
            $monthly = $perMonth->multiply('1.2')->roundToUnit(2, Money::ROUND_UP)->subtract(new Money(1, $currency));
            $monthlyPrice = json_encode($monthly->jsonSerialize());
            $data = [
                'active' => 1,
                'company_id' => 1,
                'location_id' => 1,
                'id' => $plan['id'],
                'title' => $plan['title'],
                'first_line' => $plan['first_line'],
                'second_line' => $plan['second_line'],
                'third_line' => $plan['third_line'],
                'forth_line' => $plan['forth_line'],
                'fifth_line' => $plan['fifth_line'],
                'description' => $plan['description'],
                'annual_price' => $plan['price'],
                'monthly_price' => $monthlyPrice,
                'monthly_minimum' => 2,
                'set_up_fee' => $plan['set_up_fee'],
                'minimum_starting_balance' => $plan['minimum_starting_balance'],
                'critical_balance' => $plan['critical_balance'],
                'minimum_balance' => $plan['minimum_balance'],
                'sku_new_annual' => $plan['starting_sku'] ?? 'TODO',
                'sku_renew_annual' => $plan['sku'] ?? 'TODO',
                'sku_new_monthly' => 'TODO',
                'sku_renew_monthly' => 'TODO',
            ];
            $this->table('plans')->insert($data)->save();
        }
    }
}
