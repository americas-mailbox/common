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
    /** @var Connection */
    private $connection;

    public function __construct(Connection $connection)
    {
        $this->connection = $connection;
    }

    public function fetch(Filter $filter): array
    {
        $sql = $this->sql($filter);

        return $this->connection->fetchAllAssociative($sql);
    }

    private function sql(Filter $filter): string
    {
        $date = $filter->getDate()->toDateString();
        $sql = <<<SQL
SELECT
    p.id, p.entered_on AS enteredOn, p.barcode,
    a.first_name AS entered_by_first_name, a.last_name AS entered_by_last_name,
    m.pmb, m.first_name, m.middle_name, m.last_name, m.suffix,
    p.back_image_file AS backImageFile,
    p.front_image_file AS frontImageFile
FROM parcels AS p
    LEFT JOIN members AS m ON p.member_id = m.member_id
    LEFT JOIN administrators AS a on p.entered_by_id = a.id
WHERE p.entered_on = '$date'
ORDER BY p.created_at ASC
SQL;
        $sql .= (new PaginateToSQL)($filter->getPaginate());

        return $sql;
    }
}
