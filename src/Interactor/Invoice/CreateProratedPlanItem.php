<?php
declare(strict_types=1);

namespace AMB\Interactor\Invoice;

use AMB\Entity\Plan;
use AMB\Interactor\RapidCityTime;
use OLPS\SimpleShop\Interactor\DBal\FindProductByName;
use Money\Currency;
use Money\Money;

final class CreateProratedPlanItem
{
    public function __construct(
        private FindProductByName $findSkuByName,
    ) {}

    public function create(Plan $plan, RapidCityTime $startDate)
    {
        if ($startDate->day === 1) {
            return null;
        }
        $firstOfMonth = $startDate->clone()->firstOfMonth()->addMonth();
        $totalDays = ($startDate->daysUntil($firstOfMonth))->count();

        $costPerDay = $this->getCostPerDay($plan);
        // divide by 100 here instead of cost per day to have more precision
        $proratedCents = (int) round(($costPerDay * $totalDays) / 100);

        $itemPrice = new Money($proratedCents, new Currency('USD'));

        $prorateSku = $this->findSkuByName->find('PRORATE_01');
        $item = (new CreateInvoiceItemFromSku())($prorateSku);

        $item
            ->setAmount($itemPrice)
            ->setTotalAmount($itemPrice);

        return $item;
    }

    private function getAnnualCost(Money $amount)
    {
        return (int) ($amount->getAmount() / 3.65);
    }

    private function getBiannualCost(Money $amount)
    {
        return (int) ($amount->getAmount() / 1.825);
    }

    private function getCostPerDay(Plan $plan): int
    {
        $amount = $plan->getPrice();

        $costMethod = 'get' . ucfirst((string) $plan->getRenewalFrequency()) . 'Cost';

        return $this->$costMethod($amount);
    }

    private function getQuarterCost(Money $amount)
    {
        return (int) ($amount->getAmount() / .9125);
    }
}
