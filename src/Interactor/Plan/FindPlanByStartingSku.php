<?php
declare(strict_types=1);

namespace AMB\Interactor\Plan;

use AMB\Entity\Plan;
use AMB\Interactor\Db\HydratePlan;
use Doctrine\DBAL\Connection;

final class FindPlanByStartingSku
{
    public function __construct(
        private Connection $connection,
        private HydratePlan $hydratePlan,
    ) {
    }

    public function find(string $sku): ?Plan
    {
        $planData = $this->gatherPlanData($sku);
        if (empty($planData)) {
            return null;
        }

        return $this->hydratePlan->hydrate($planData);
    }

    private function gatherPlanData(string $sku): ?array
    {
        $sql = "SELECT * FROM rates_and_plans WHERE starting_sku = '$sku'";

        return $this->connection->fetchAssociative($sql);
    }
}
