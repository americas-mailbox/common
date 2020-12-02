<?php
declare(strict_types=1);

namespace AMB\Interactor\Admin;

use AMB\Factory\DbalConnection;
use AMB\Interactor\DbalConnectionTrait;
use Doctrine\DBAL\Connection;

final class GatherAdminDataById
{
    /** @var Connection */
    private $connection;

    public function __construct(Connection $connection)
    {
        $this->connection = $connection;
    }
    public function gather($adminId)
    {
        $sql = $this->sql($adminId);
        $statement = $this->connection->executeQuery($sql);
        $adminData = $statement->fetch();
        if (empty($adminData)) {
            return null;
        }

        return $adminData;
    }

    private function sql($adminId): string
    {
        return <<<SQL
SELECT * FROM administrators
WHERE id = $adminId;
SQL;
    }
}
