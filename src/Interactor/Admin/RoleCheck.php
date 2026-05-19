<?php
declare(strict_types=1);

namespace AMB\Interactor\Admin;

use AMB\Entity\AdminRole;

final class RoleCheck
{
    public function __invoke($adminRole, $requiredRole): bool
    {
        if (!is_object($adminRole)) {
            $adminRole = \AMB\Entity\AdminRole::from($adminRole);
        }

        if (!is_object($requiredRole)) {
            $requiredRole = \AMB\Entity\AdminRole::from($requiredRole);
        }

        // quickest path out for a single role matching the admin role
        if ($adminRole->equals($requiredRole)) {
            return true;
        }

        // A master can do anything
        if ($adminRole->equals(\AMB\Entity\AdminRole::MASTER)) {
            return true;
        }

        // A manager can do the staff role
        if ($adminRole->equals(\AMB\Entity\AdminRole::MANAGER) && \AMB\Entity\AdminRole::STAFF->equals($requiredRole)) {
            return true;
        }

        return false;
    }
}
