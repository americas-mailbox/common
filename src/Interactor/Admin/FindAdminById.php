<?php
declare(strict_types=1);

namespace AMB\Interactor\Admin;

use AMB\Entity\Admin;
use AMB\Interactor\Db\HydrateAdmin;
use Zestic\Contracts\User\FindUserByIdInterface;
use Zestic\Contracts\User\UserInterface;

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
}
