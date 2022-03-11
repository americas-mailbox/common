<?php
declare(strict_types=1);

namespace AMB\Interactor\OfficeClosure;

use AMB\Factory\DbalConnection;
use AMB\Interactor\DbalConnectionTrait;

final class DeleteOfficeClosureDate implements DbalConnection
{
    use DbalConnectionTrait;

    public function delete($id)
    {
        $sql = <<<SQL
DELETE FROM office_closures
WHERE id = $id
SQL;

        $results = $this->connection->executeQuery($sql);
    }
}