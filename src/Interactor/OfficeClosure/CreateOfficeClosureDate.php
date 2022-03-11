<?php
declare(strict_types=1);

namespace AMB\Interactor\OfficeClosure;

use AMB\Factory\DbalConnection;
use AMB\Interactor\DbalConnectionTrait;
use AMB\Interactor\RapidCityTime;

final class CreateOfficeClosureDate implements DbalConnection
{
    use DbalConnectionTrait;

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
