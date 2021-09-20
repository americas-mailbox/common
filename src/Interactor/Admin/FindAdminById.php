<?php
declare(strict_types=1);

namespace AMB\Interactor\Admin;

use AMB\Interactor\Db\HydrateAdmin;
use Zestic\Contracts\User\FindUserByIdInterface;
use Zestic\Contracts\User\UserInterface;

final class FindAdminById implements FindUserByIdInterface
{
    /** @var \AMB\Interactor\Admin\GatherAdminDataById */
    private $gatherAdminData;
    /** @var \AMB\Interactor\Db\HydrateAdmin */
    private $hydrateAdmin;

    public function __construct(GatherAdminDataById $gatherAdminData)
    {
        $this->gatherAdminData = $gatherAdminData;
        $this->hydrateAdmin = new HydrateAdmin();
    }

    public function find($id): ?UserInterface
    {
        if (!$data = $this->gatherAdminData->gather($id)) {
            return null;
        }

        return $this->hydrateAdmin->hydrate($data);
    }
}
