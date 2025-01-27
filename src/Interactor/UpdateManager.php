<?php
declare(strict_types=1);

namespace AMB\Interactor;

use Doctrine\DBAL\Connection;

final class UpdateManager
{
    public function __construct(
        private Connection $connection,
    ) {
    }

    public function drop(string $key)
    {
        $sql = <<<SQL
DELETE FROM update_store WHERE `key` = '$key';
SQL;
        $result = $this->connection->executeStatement($sql);
    }

    public function get(string $key): ?string
    {
        $sql = <<<SQL
SELECT value FROM update_store WHERE `key` = '$key';
SQL;
        $value = $this->connection->fetchOne($sql);

        return $value ? (string) $value : null;
    }

    public function set(string $key, $value): bool
    {
        $sql = <<<SQL
INSERT INTO update_store (`key`, `value`)
VALUES ('$key', '$value')
ON DUPLICATE KEY UPDATE
   `key` = '$key', 
   `value` = '$value';
SQL;
        $result = $this->connection->executeStatement($sql);

        return false;
    }
}
