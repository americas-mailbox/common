<?php
declare(strict_types=1);

namespace AMB\Interactor\Shipping;

use Carbon\Carbon;
use Doctrine\DBAL\Connection;

final class FetchCustomerPickupListData
{
    /** @var Connection */
    private $connection;

    public function __construct(Connection $connection)
    {
        $this->connection = $connection;
    }

    public function fetch(Carbon $date): array
    {
        $sql = $this->sql($date);

        return $this->connection->fetchAllAssociative($sql);
    }

    private function sql(Carbon $date): string
    {
        return <<<SQL
SELECT
    s.id,
    s.fulfilled_date as shippedAt,
    m.pmb, m.first_name, m.middle_name, m.last_name, m.suffix,
    '' as pickupSignature
FROM shipments AS s
    LEFT JOIN deliveries AS d ON s.delivery_id = d.id
    LEFT JOIN members AS m ON m.member_id = s.member_id
WHERE s.date = '{$date->toDateString()}'
AND s.delivery_method_id = 7
ORDER BY m.pmb ASC
SQL;
    }
}
