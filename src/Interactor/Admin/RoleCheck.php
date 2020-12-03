<?php
declare(strict_types=1);

namespace AMB\Interactor\Admin;

use AMB\Entity\AdminRole;

final class RoleCheck
{
    public function __invoke($adminRole, $requiredRole): bool
    {
        if (!is_object($adminRole)) {
            $adminRole = new AdminRole($adminRole);
        }

        if (!is_object($requiredRole)) {
            $requiredRole = new AdminRole($requiredRole);
        }

        // quickest path out for a single role matching the admin role
        if ($adminRole->equals($requiredRole)) {
            return true;
        }

        // A master can do anything
        if ($adminRole->equals(AdminRole::MASTER())) {
            return true;
        }

        // A manager can do the staff role
        if ($adminRole->equals(AdminRole::MANAGER()) && AdminRole::STAFF()->equals($requiredRole)) {
            return true;
        }

        return false;
    }
}
