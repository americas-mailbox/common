<?php
declare(strict_types=1);

namespace AMB\Interactor\Address;

use Doctrine\DBAL\Connection;

final class DeleteAddress
{
    public function __construct(
        private Connection $connection,
    ) {
    }

    public function delete($addressId): bool
    {
        $delete = ['deleted' => 1];
        $response = $this->connection->update('addresses', $delete, ['id' => $addressId]);
        if (1 !== $response) {
            return false;
        }

        return $this->removeIfDefault($addressId);
    }

    private function removeIfDefault($addressId): bool
    {
        $sql = <<<SQL
SELECT id FROM accounts WHERE default_address_id = $addressId;
SQL;
        $accountId = $this->connection->fetchOne($sql);
        if (!$accountId) {
            return true;
        }

        $response = $this->connection->update(
            'accounts',
            ['default_address_id' => 'NULL'],
            ['id' => $accountId]
        );

        return 1 !== $response ? false: true;
    }
}
