<?php
declare(strict_types=1);

namespace AMB\Interactor\Parcel;

use AMB\Entity\Filter;
use AMB\Entity\Paginate;
use AMB\Interactor\Db\PaginateToSQL;
use Carbon\Carbon;
use Doctrine\DBAL\Connection;

final class FetchUnstoredParcelsListData
{
    public function __construct(
        private Connection $connection,
    ){
    }

    public function fetch(Filter $filter): array
    {
        $sql = $this->sql($filter);

        return $this->connection->fetchAllAssociative($sql);
    }

    private function sql(Filter $filter): string
    {
        $sql = (new ParcelSQL)();
        $sql .= <<<SQL
WHERE location_id IS NULL
ORDER BY parcels.created_at ASC
SQL;
        $sql .= (new PaginateToSQL)($filter->getPaginate());

        return $sql;
    }
}
