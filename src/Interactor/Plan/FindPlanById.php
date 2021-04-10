<?php
declare(strict_types=1);

namespace AMB\Interactor\Plan;

use AMB\Entity\Plan;
use AMB\Interactor\Db\HydratePlan;
use Doctrine\DBAL\Connection;

final class FindPlanById
{
    public function __construct(
        private Connection $connection,
        private HydratePlan $hydratePlan,
    ) {
    }

    public function find($planId): ?Plan
    {
        $planData = $this->gatherPlanData($planId);
        if (empty($planData)) {
            return null;
        }

        return $this->hydratePlan->hydrate($planData);
    }

    private function gatherPlanData($planId): ?array
    {
        $sql = "SELECT * FROM rates_and_plans WHERE id = $planId";

        return $this->connection->fetchAssociative($sql);
    }
}
