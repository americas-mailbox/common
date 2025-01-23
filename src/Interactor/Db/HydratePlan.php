<?php
declare(strict_types=1);

namespace AMB\Interactor\Db;

use AMB\Entity\Plan;
use AMB\Entity\RenewalFrequency;
use OLPS\Money\Interactor\JsonToMoney;
use OLPS\SimpleShop\Interactor\DBal\FindProductByName;

final class HydratePlan
{
    public function __construct(
        private FindProductByName $findSkuByName,
    ) {}

    public function hydrate(array $planData): Plan
    {
        $sku = $this->findSkuByName->find($planData['sku']);
        $startingSku = $this->findSkuByName->find($planData['starting_sku']);

        return (new Plan())
            ->setCriticalBalance((new JsonToMoney)($planData['critical_balance']))
            ->setGroup($planData['group'])
            ->setId((int)$planData['id'])
            ->setMinimumBalance((new JsonToMoney)($planData['minimum_balance']))
            ->setMinimumStartingBalance((new JsonToMoney)($planData['minimum_starting_balance']))
            ->setPrice((new JsonToMoney)($planData['price']))
            ->setRenewalFrequency(new RenewalFrequency($planData['renewal_frequency']))
            ->setSetUpFee((new JsonToMoney)($planData['set_up_fee']))
            ->setSku($sku)
            ->setStartingSku($startingSku)
            ->setTitle($planData['title']);
    }
}
