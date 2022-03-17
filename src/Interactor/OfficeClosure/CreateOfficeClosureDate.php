<?php
declare(strict_types=1);

namespace AMB\Interactor\OfficeClosure;

use AMB\Interactor\RapidCityTime;
use Doctrine\DBAL\Connection;

final class CreateOfficeClosureDate
{
    public function __construct(
        private Connection $connection,
    ) {}

    public function create(array $data): int
    {
        $data = [
            'date'             => (new RapidCityTime($data['date']))->format('Y-m-d'),
            'description'      => $data['description'],
        ];
        $response = $this->connection->insert('office_closures', $data);
        if (1 === $response) {
            $id = $this->connection->lastInsertId();

            return (int) $id;
        }
    }
}
