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
            '5'       => [],
            '15'      => [],
            'BREAK-1' => [],
            '7'       => [],
            'BREAK-2' => [],
            '8'       => [],
            '9'       => [],
            '10'      => [],
            '12'      => [],
            '18'      => [],
            '11'      => [],
            'BREAK-3' => [],
            '14'      => [],
            '17'      => [],
            'BREAK-4' => [],
            '20'      => [],
            '21'      => [],
            '22'      => [],
            '23'      => [],
            'BREAK-5' => [],
            '6'       => [],
            '16'      => [],
        ];
        foreach ($results as $result) {
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
            $deliveryMethodId = (string)$result['id'];
            $data[$deliveryMethodId][] = [
                'active' => $result['active'],
                'balance' => $this->getBalance($result),
                'destination' => $address,
                'plan' => $result['title'],
                'shippingInstructions' => $result['shippingInstructions'],
                'suspended' => $result['suspended'],
                'userDescription' => 'PMB #' . $result['pmb'] . ': ' . $fullName,
            ];
        }

        $lists = [];
        foreach ($data as $methodId => $datum) {
            if (!empty($datum) || !is_int($methodId)) {
                $lists[$methodId] = $datum;
            }
        }

        return [
            'labels'       => $this->getDeliveryMethodLabels(),
            'lists'        => $lists,
            'shippingDate' => $date,
        ];
    }

    private function getBalance(array $data): string
    {
        return (new JsonToString)($data['balance']);
    }

    private function getDeliveryMethodLabels(): array
    {
        $sql = <<<SQL
SELECT id, internal_label as label, internal_short_label as shortLabel
FROM delivery_methods 
WHERE active = 1;
SQL;

        $data = $this->connection->fetchAllAssociative($sql);

        $results = [];
        foreach ($data as $datum) {
            $results[$datum['id']] = $datum;
        }

        return $results;
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
       p.title, m.phone, d.id, d.internal_label, d.internal_short_label
FROM shipments AS s
LEFT JOIN delivery_methods AS d ON s.delivery_method_id = d.id
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
