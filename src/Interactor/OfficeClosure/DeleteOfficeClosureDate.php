<?php
declare(strict_types=1);

namespace AMB\Interactor\OfficeClosure;

use Doctrine\DBAL\Connection;

final class DeleteOfficeClosureDate
{
    public function __construct(
        private Connection $connection,
    ) {}

    public function delete($id)
    {
        $sql = <<<SQL
DELETE FROM office_closures
WHERE id = $id
SQL;

        $results = $this->connection->executeQuery($sql);
    }
}
