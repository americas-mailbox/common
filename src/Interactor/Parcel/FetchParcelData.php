<?php
declare(strict_types=1);

namespace AMB\Interactor\Parcel;

use Doctrine\DBAL\Connection;

final class FetchParcelData
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
WHERE p.id = '$id'
ORDER BY p.created_at ASC
SQL;

        return $sql;
    }
}
