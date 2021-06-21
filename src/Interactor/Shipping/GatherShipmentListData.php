<?php
declare(strict_types=1);

namespace AMB\Interactor\Shipping;

use AMB\Interactor\FullName;
use Carbon\Carbon;
use Doctrine\DBAL\Connection;
use IamPersistent\Money\Interactor\JsonToString;

final class GatherShipmentListData
{
    public function __construct(
        private Connection $connection,
    ) {}

    public function gather(Carbon $date): array
    {
        $sql = $this->sql($date);
        $results = $this->connection->fetchAllAssociative($sql);
        $data = [
            'Best Method'                                    => [],
            'Best Method - International'                    => [],
            'Customer Pick Up'                               => [],
            'FedEx - 2nd Day Air'                            => [],
            'FedEx - 3rd Day Air'                            => [],
            'FedEx - Ground'                                 => [],
            'FedEx - International'                          => [],
            'FedEx - Overnight'                              => [],
            'US Postal Service - Express 2 Day Service'      => [],
            'US Postal Service - First Class (if available)' => [],
            'US Postal Service - International'              => [],
            'US Postal Service - Priority'                   => [],
            'UPS - Ground'                                   => [],
            'UPS - Next Day Air'                             => [],
            'UPS - Next Day Air Early'                       => [],
            'UPS - Next Day Air Saver'                       => [],
            'UPS - 2nd Day Air'                              => [],
            'UPS - 2nd Day Air A.M.'                         => [],
            'UPS - 3 Day Select'                             => [],
        ];
        foreach ($results as $result) {
            $deliveryMethod = $this->getDeliveryMethod($result);
            $fullName = (new FullName())($result);
            $addressParts = [
                $result['addressee'],
                $result['location_name'],
                $result['in_care_of'],
                $result['address'],
                $result['suite'],
                $result['city'],
                $result['state'],
                $result['post_code'],
                $result['country'],
            ];
            $address = implode(', ', $addressParts);
            $data[$deliveryMethod][] = [
                'active' => $result['active'],
                'balance' => (new JsonToString)($result['balance']),
                'destination' => $address,
                'plan' => $result['title'],
                'shippingInstructions' => $result['shippingInstructions'],
                'suspended' => $result['suspended'],
                'userDescription' => 'PMB #' . $result['pmb'] . ': ' . $fullName,
            ];
        }

        $returnData = [];
        foreach ($data as $label => $datum) {
            if (!empty($datum)) {
                $returnData[$label] = $datum;
            }
        }

        return $returnData;
    }

    private function getDeliveryMethod(array $data): string
    {
        $label = '';
        if (!empty($data['carrier'])) {
            $label = $data['carrier'] . ' - ';
        }
        $label .= $data['label'];

        return $label;
    }

    private function sql(Carbon $date): string
    {
        $date = $date->toDateString();
        return <<<SQL
SELECT
       m.pmb, m.first_name, m.middle_name, m.last_name, m.suffix,
       m.active, m.suspended, m.shipinst as shippingInstructions,
       l.balance, 
       a.addressee,
       a.address, a.suite, a.location_name, a.in_care_of, a.city, a.state, a.post_code, a.country,
       p.title, m.phone, d.id, d.label, dc.name AS carrier
FROM shipments AS s
LEFT JOIN delivery_methods AS d ON s.delivery_method_id = d.id
LEFT JOIN delivery_carriers AS dc ON d.company_id = dc.id
LEFT JOIN members AS m ON m.member_id = s.member_id
LEFT JOIN addresses AS a ON a.id = s.address_id
LEFT JOIN accounts ON accounts.id = m.account_id
LEFT JOIN ledgers AS l ON l.id = accounts.ledger_id
LEFT JOIN rates_and_plans AS p ON m.level_id = p.id
WHERE s.date = '$date'
ORDER BY m.pmb ASC
SQL;
    }
}
