<?php
declare(strict_types=1);

namespace AMB\Interactor\Parcel;

use Doctrine\DBAL\Connection;

final class FetchPickItemData
{
    public function __construct(
        private Connection $connection
    ) { }

    public function fetch(string $id): array
    {
        $sql = $this->sql($id);

        return $this->connection->fetchAssociative($sql);
    }

    private function sql(string $id): string
    {
        $sql = (new ParcelSQL)();
        $sql .= <<<SQL
LEFT JOIN shipments ON shipments.member_id = parcels.member_id
WHERE parcels.id = '$id'
SQL;

        return $sql;
    }
}
