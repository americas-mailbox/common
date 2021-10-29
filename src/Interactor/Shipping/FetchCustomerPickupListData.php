<?php
declare(strict_types=1);

namespace AMB\Interactor\Shipping;

use AMB\Interactor\Db\SQLToBool;
use AMB\Interactor\FullName;
use Carbon\Carbon;
use Doctrine\DBAL\Connection;

final class FetchCustomerPickupListData
{
    /** @var Connection */
    private $connection;
    /** @var array */
    private $parcels;

    public function __construct(Connection $connection)
    {
        $this->connection = $connection;
    }

    public function fetch(Carbon $date): array
    {
        $sql = $this->sql($date);

        $shipments = $this->connection->fetchAllAssociative($sql);

        $this->loadParcels($date);

        foreach ($shipments as $index => $shipment) {
            $shipments[$index]['fulfilled'] = (new SQLToBool)($shipment['fulfilled']);
            $shipments[$index]['parcels'] = $this->getParcelsForPmb($shipment['pmb']);
        }

        return $shipments;
    }

    private function getParcelsForPmb(string $pmb): array
    {
        $parcels = [];
        $loadedParcels = $this->parcels;
        foreach ($loadedParcels as $index => $parcel) {
            if ($pmb === $parcel['pmb']) {
                $parcels[] = $parcel;
                unset($this->parcels[$index]);
            }
        }

        return $parcels;
    }

    private function loadParcels(Carbon $date)
    {
        $sql = $this->parcelSql($date);
        $data = $this->connection->fetchAllAssociative($sql);
        $this->parcels = [];
        $fullName = new FullName();
        foreach ($data as $datum) {
            $datum['enteredBy'] = [
                'firstName' => $datum['enteredByFirstName'],
                'lastName'  => $datum['enteredByLastName'],
            ];
            $datum['name'] = $fullName($datum, true);
            $this->parcels[] = $datum;
        }
    }

    private function sql(Carbon $date): string
    {
        return <<<SQL
SELECT
    s.id,
    s.fulfilled, s.fulfilled_date as fulfilledAt,
    m.pmb, m.first_name, m.middle_name, m.last_name, m.suffix,
    s.customer_signature_url as customerSignature
FROM shipments AS s
    LEFT JOIN deliveries AS d ON s.delivery_id = d.id
    LEFT JOIN members AS m ON m.member_id = s.member_id
WHERE s.date = '{$date->toDateString()}'
AND s.delivery_method_id = 7
ORDER BY m.pmb ASC
SQL;
    }

    private function parcelSql(Carbon $date): string
    {
        return <<<SQL
SELECT
    p.back_image_file as backImage,
    p.barcode,
    a.first_name as enteredByFirstName,
    a.last_name as enteredByLastName,
    p.entered_on as enteredOn,
    p.front_image_file as frontImage,
    p.id,
    m.pmb, m.first_name, m.middle_name, m.last_name, m.suffix,
    p.thumbnail_file as thumbnail
FROM parcels AS p
    LEFT JOIN shipments AS s ON p.shipment_id = s.id
    LEFT JOIN administrators AS a ON p.entered_by_id = a.id
    LEFT JOIN members AS m ON s.member_id = m.member_id
WHERE s.date = '{$date->toDateString()}'
AND s.delivery_method_id = 7
ORDER BY m.pmb ASC
SQL;
    }
}
