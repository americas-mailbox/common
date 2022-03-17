<?php
declare(strict_types=1);

namespace AMB\Interactor\ShippingEvent;

use AMB\Interactor\RapidCityTime;
use Doctrine\DBAL\Connection;

final class GatherScheduledShipmentsData
{
    public function __construct(
        private Connection $connection,
    ) { }

    public function gather($memberId, RapidCityTime $date, $months): ?array
    {
        $sql = (new SelectShippingEventSQL)() . <<<SQL
WHERE e.member_id = $memberId
    AND end_date >= '{$date->toDateString()}'
    AND e.is_active = 1
ORDER BY start_date
SQL;
        $data = $this->connection->fetchAllAssociative($sql);
        if (empty($data)) {
            return null;
        }

        return $data;
    }
}
