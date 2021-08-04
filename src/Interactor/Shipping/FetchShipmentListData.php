<?php
declare(strict_types=1);

namespace AMB\Interactor\Shipping;

use AMB\Entity\Paginate;
use AMB\Interactor\Db\PaginateToSQL;
use Carbon\Carbon;
use Doctrine\DBAL\Connection;

final class FetchShipmentListData
{
    public function __construct(
        private Connection $connection,
    ) { }

    public function fetch(Carbon $date, Paginate $paginate = null): array
    {
        $sql = $this->sql($date, $paginate);

        return $this->connection->fetchAllAssociative($sql);
    }

    private function sql(Carbon $date, Paginate $paginate = null): string
    {
        $date = $date->toDateString();
        $sql = <<<SQL
SELECT
    s.id,
    m.pmb, m.first_name, m.middle_name, m.last_name, m.suffix,
    m.active, m.suspended, m.shipinst as shippingInstructions,
    d.tracking_number, shippingMethodCarrier.name AS trackingCarrier,
    s.fulfilled_date, s.customer_signature_url as customerSignature,
    l.balance, 
    a.addressee,
    a.address, a.suite, a.location_name, a.in_care_of, a.city, a.state, a.post_code, a.plus4, a.country,
    p.title as plan, m.phone, 
    preferredMethod.id as delivery_method_id,
    CONCAT_WS(' ', preferredCarrier.name, preferredMethod.label) AS preferredShippingMethod,
    CONCAT_WS(' ', shippingMethodCarrier.name, shippingMethod.label) AS shippingMethod
FROM shipments AS s
    LEFT JOIN deliveries AS d ON s.delivery_id = d.id
    
    LEFT JOIN delivery_methods_services AS ams ON d.service_code = ams.service_code
    LEFT JOIN delivery_methods AS shippingMethod ON ams.delivery_method_id = shippingMethod.id
    LEFT JOIN delivery_carriers AS shippingMethodCarrier ON d.carrier_id = shippingMethodCarrier.id
    
    LEFT JOIN delivery_methods AS preferredMethod ON s.delivery_method_id = preferredMethod.id
    LEFT JOIN delivery_carriers AS preferredCarrier ON preferredMethod.company_id = preferredCarrier.id

    LEFT JOIN members AS m ON m.member_id = s.member_id
    LEFT JOIN addresses AS a ON a.id = s.address_id
    LEFT JOIN accounts ON accounts.id = m.account_id
    LEFT JOIN ledgers AS l ON l.id = accounts.ledger_id
    LEFT JOIN rates_and_plans AS p ON m.level_id = p.id
WHERE s.date = '$date'
ORDER BY m.pmb ASC
SQL;
        $sql .= (new PaginateToSQL)($paginate);

        return $sql;
    }
}
