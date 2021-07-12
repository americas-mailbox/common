<?php
declare(strict_types=1);

use AMB\Interactor\Parcel\ParcelSQL;
use Doctrine\DBAL\Connection;

final class FetchLocationByLabel
{
    public function __construct(
        private Connection $connection
    ) { }

    public function fetch(string $label): array
    {
        $sql = $this->sql($barcode);

        return $this->connection->fetchAssociative($sql);
    }

    private function sql(string $label): string
    {
        $sql = (new ParcelSQL)();
        $sql = <<<SQL
SELECT 
  id AS location_id,
  label AS location_label
WHERE parcel_locations.label = '$label'
SQL;

        return $sql;
    }
}
