<?php
declare(strict_types=1);

namespace AMB\Interactor\Parcel;

use AMB\Entity\Filter;
use AMB\Entity\Paginate;
use AMB\Interactor\Db\PaginateToSQL;
use Carbon\Carbon;
use Doctrine\DBAL\Connection;

final class FetchParcelListData
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
        $date = $filter->getDate()->toDateString();
        $sql = (new ParcelSQL)();
        $sql .= <<<SQL
WHERE parcels.entered_on = '$date'
ORDER BY parcels.created_at DESC
SQL;
        $sql .= (new PaginateToSQL)($filter->getPaginate());

        return $sql;
    }
}
