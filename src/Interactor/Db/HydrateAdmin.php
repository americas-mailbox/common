<?php
declare(strict_types=1);

namespace AMB\Interactor\Db;

use AMB\Entity\Admin;
use AMB\Entity\AdminRole;

final class HydrateAdmin
{
    public function hydrate(array $data): Admin
    {
        return (new Admin())
            ->setEmail($data['email'])
            ->setFirstName($data['first_name'])
            ->setId((int)$data['id'])
            ->setLastName($data['last_name'])
            ->setRole(new AdminRole($data['role']))
            ->setStatus((int)$data['status'])
            ->setUsername($data['username']);
    }
}
