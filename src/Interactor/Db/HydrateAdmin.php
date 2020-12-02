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
            ->setId((int) $data['id'])
            ->setRole(new AdminRole($data['role']))
            ->setUsername($data['username']);
    }
}
