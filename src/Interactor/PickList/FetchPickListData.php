<?php
declare(strict_types=1);

namespace AMB\Interactor\PickList;

use AMB\Entity\Filter;
use AMB\Entity\Paginate;
use AMB\Interactor\Db\PaginateToSQL;
use AMB\Interactor\Parcel\ParcelSQL;
use Carbon\Carbon;
use Doctrine\DBAL\Connection;

final class FetchPickListData
{
    public function __construct(
        private Connection $connection,
    ){
    }

    public function fetch(Filter $filter): array
    {
        $sql = $this->sql($filter);

        $rawData = $this->connection->fetchAllAssociative($sql);

        return $this->prepData($rawData);
    }

    private function prepData(array $rawData): array
    {
        $data = [];
        foreach ($rawData as $datum) {
            $data[$datum['location_id']]['parcels'][] = $datum;
            $data[$datum['location_id']]['location_id'] = $datum['location_id'];
            $data[$datum['location_id']]['location_label'] = $datum['location_label'];
        }

        return $data;
    }

    private function sql(Filter $filter): string
    {
        $date = $filter->getDate()->toDateString();
        $sql = (new ParcelSQL)();
        $sql .= <<<SQL
LEFT JOIN shipments ON shipments.member_id = parcels.member_id
WHERE shipments.date = '$date'
SQL;
        $sql .= (new PaginateToSQL)($filter->getPaginate());

        return $sql;
    }
}
