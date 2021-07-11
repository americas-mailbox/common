<?php
declare(strict_types=1);

namespace AMB\Interactor\Parcel;

use Doctrine\DBAL\Connection;

final class FetchParcelByBarcodeData
{
    public function __construct(
        private Connection $connection
    ) { }

    public function fetch(string $barcode): array
    {
        $sql = $this->sql($barcode);

        return $this->connection->fetchAssociative($sql);
    }

    private function sql(string $barcode): string
    {
        $sql = (new ParcelSQL)();
        $sql .= <<<SQL
WHERE parcels.barcode = '$barcode'
SQL;

        return $sql;
    }
}
