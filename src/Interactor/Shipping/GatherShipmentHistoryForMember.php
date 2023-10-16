<?php
declare(strict_types=1);

namespace AMB\Interactor\Shipping;

use App\Entity\Paginate;
use Doctrine\DBAL\Connection;
use Infrastructure\SQLBuilder\PaginateToSQL;

final class GatherShipmentHistoryForMember
{
    public function __construct(
        private Connection $connection,
    ) {
    }

    public function gather(int $memberId, Paginate $paginate = null)
    {
        return $this->connection->fetchAllAssociative($this->sql($memberId, $paginate));
    }

    private function sql($memberId, Paginate $paginate = null): string
    {
        $paginateSql = (new PaginateToSQL)($paginate);

        return <<<SQL
SELECT 
s.id,
s.date,
a.address,
a.suite,
a.city,
a.state,
dc.name AS carrierName,
d.tracking_number as trackingNumber,
dm.group AS deliveryGroup,
le.debit AS charge
FROM shipments s
LEFT JOIN addresses a ON s.address_id = a.id
LEFT JOIN deliveries d ON s.delivery_id = d.id 
LEFT JOIN delivery_carriers dc ON d.carrier_id = dc.id
LEFT JOIN delivery_methods dm ON s.delivery_method_id = dm.id 
LEFT JOIN members m ON s.member_id = m.member_id
LEFT JOIN accounts ac ON m.account_id = ac.id
LEFT JOIN ledgers l on ac.ledger_id = l.id
LEFT JOIN ledger_entries le ON l.id = le.ledger_id AND s.date = le.date
WHERE s.member_id = $memberId
AND fulfilled = 1
ORDER BY date DESC
$paginateSql
SQL;
    }
}
