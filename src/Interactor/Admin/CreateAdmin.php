<?php
declare(strict_types=1);

namespace AMB\Interactor\Admin;

use AMB\Interactor\Db\HydrateAdmin;
use Doctrine\DBAL\Connection;
use Zestic\Contracts\User\CreateUserInterface;
use Zestic\Contracts\User\UserInterface;

final class CreateAdmin implements CreateUserInterface
{
    public function __construct(
        private Connection $connection,
    ) {
    }

    public function create($data = null): UserInterface
    {
        $adminData = $data->getData();
        $this->connection->insert('administrators', $adminData);
        $adminData['id'] = (int) $this->connection->lastInsertId();
        $adminData['password'] = sha1($adminData['password']);

        return (new HydrateAdmin())->hydrate($adminData);
    }
}
