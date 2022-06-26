<?php
declare(strict_types=1);

namespace AMB\Interactor\Address;

use AMB\Entity\Address;
use AMB\Interactor\Db\HydrateAddress;
use Doctrine\DBAL\Connection;

final class FindAddressById
{
    public function __construct(
        private Connection $connection,
        private HydrateAddress $hydrateAddress
    ) { }

    public function find($addressId): ?Address
    {
        $sql = $this->sql($addressId);
        $statement = $this->connection->executeQuery($sql);
        $addressData = $statement->fetchAssociative();
        if (empty($addressData)) {
            return null;
        }

        return $this->hydrateAddress->hydrate($addressData);
    }

    private function sql($addressId): string
    {
        return <<<SQL
SELECT * 
FROM addresses 
WHERE id = $addressId;
SQL;
    }
}
