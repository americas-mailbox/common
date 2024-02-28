<?php
declare(strict_types=1);

namespace AMB\Interactor\Admin;

use AMB\Entity\Admin;
use AMB\Interactor\Db\HydrateAdmin;
use Mezzio\Authentication\UserInterface;
use Zestic\Authentication\Interface\FindUserByIdInterface;

final class FindAdminById implements FindUserByIdInterface
{
    public function __construct(
        private GatherAdminDataById $gatherAdminData,
    ) {
    }

    public function find($id): ?Admin
    {
        if (!$data = $this->gatherAdminData->gather($id)) {
            return null;
        }

        return (new HydrateAdmin())->hydrate($data);
    }

    public function findById($id): ?UserInterface
    {
        return $this->find($id)
    }
}
