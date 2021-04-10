<?php
declare(strict_types=1);

namespace AMB\Interactor\Member;

use AMB\Entity\Member;
use AMB\Interactor\Db\HydrateMember;
use AMB\Interactor\Db\SelectMemberSQL;
use Doctrine\DBAL\Connection;

final class FindMemberByPmb
{
    public function __construct(
        private Connection $connection,
        private HydrateMember $hydrateMember
    ) {
    }

    public function find($pmb): ?Member
    {
        $memberData = $this->gather($pmb);
        if (empty($memberData)) {
            return null;
        }

        return $this->hydrateMember->hydrate($memberData);
    }

    public function gather($pmb)
    {
        $sql = $this->sql($pmb);
        $statement = $this->connection->executeQuery($sql);
        $memberData = $statement->fetchAssociative();
        if (empty($memberData)) {
            return null;
        }

        return $memberData;
    }

    private function sql($pmb): string
    {
        return (new SelectMemberSQL)() .
            "WHERE pmb = $pmb;";
    }
}
