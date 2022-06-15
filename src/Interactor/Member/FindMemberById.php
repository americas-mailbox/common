<?php
declare(strict_types=1);

namespace AMB\Interactor\Member;

use AMB\Entity\Member;
use AMB\Interactor\Db\HydrateMember;
use AMB\Interactor\Db\SelectMemberSQL;
use Doctrine\DBAL\Connection;
use Zestic\Contracts\User\FindUserByIdInterface;

final class FindMemberById implements FindUserByIdInterface
{
    public function __construct(
        private Connection $connection,
        private HydrateMember $hydrateMember
    ) {
    }

    public function find($id): ?Member
    {
        $memberData = $this->gather($id);
        if (empty($memberData)) {
            return null;
        }

        return $this->hydrateMember->hydrate($memberData);
    }

    public function gather($id)
    {
        $sql = $this->sql($id);
        $statement = $this->connection->executeQuery($sql);
        $memberData = $statement->fetchAssociative();
        if (empty($memberData)) {
            return null;
        }

        return $memberData;
    }

    private function sql($id): string
    {
        return (new SelectMemberSQL)() .
            "WHERE m.member_id = $id;";
    }
}
