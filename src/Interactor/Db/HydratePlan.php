<?php
declare(strict_types=1);

namespace AMB\Interactor\Db;

use AMB\Entity\Plan;
use AMB\Entity\RenewalFrequency;
use IamPersistent\Money\Interactor\JsonToMoney;

final class HydratePlan
{
    public function hydrate(array $planData): Plan
    {
        return (new Plan())
            ->setCriticalBalance((new JsonToMoney)($planData['critical_balance']))
            ->setGroup($planData['group'])
            ->setId((int)$planData['id'])
            ->setMinimumBalance((new JsonToMoney)($planData['minimum_balance']))
            ->setPrice((new JsonToMoney)($planData['price']))
            ->setRenewalFrequency(new RenewalFrequency($planData['renewal_frequency']))
            ->setSetUpFee((new JsonToMoney)($planData['set_up_fee']))
            ->setTitle($planData['title']);
    }
}
