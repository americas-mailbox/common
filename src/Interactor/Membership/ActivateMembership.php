<?php
declare(strict_types=1);

namespace AMB\Interactor\Membership;

use AMB\Entity\Member;
use AMB\Entity\MemberStatus;
use AMB\Interactor\Member\FindMemberById;
use AMB\Interactor\Member\UpdateMember;
use AMB\Interactor\Member\UpdateMemberPassword;
use Doctrine\DBAL\Connection;
use Doctrine\DBAL\Exception\UniqueConstraintViolationException;

final class ActivateMembership
{
    public function __construct(
        private Connection $connection,
        private FindMemberById $findMemberById,
        private UpdateMember $updateMember,
        private UpdateMemberPassword $updateMemberPassword,
    ) { }

    public function activate($membershipId)
    {
        $membership = $this->findMemberById->find($membershipId);
        $this->setPMB($membership);
        $membership
            ->setActive(new MemberStatus(MemberStatus::ACTIVE))
            ->setSuspended(false);
        $this->updateMember->update($membership);
        $this->setMemberPassword($membership);
        $this->setUseNewDashboard($membership);
    }

    private function setPMB(Member $membership)
    {
        do {
            $successful = true;
            $pmb = $this->getNextPMB();
            $membership->setPMB((string)$pmb);
            try {
                $this->connection->update(
                    'members',
                    ['pmb' => $pmb],
                    ['member_id' => $membership->getId()],
                );
            } catch (UniqueConstraintViolationException $e) {
                $successful = false;
            }
        } while (!$successful);
    }

    private function getNextPMB()
    {
        $sql = <<<SQL
SELECT pmb
FROM members
WHERE pmb < 30326 OR pmb > 30328
ORDER BY pmb DESC
LIMIT 1
SQL;
        $statement = $this->connection->executeQuery($sql);
        $pmb = $statement->fetchColumn();
        if ($pmb === 30325) {
            $pmb = 30328;
        }

        return $pmb + 1;
    }

    private function setMemberPassword(Member $membership)
    {
        $password = $membership->getPMB() . ucfirst(strtolower($membership->getLastName()));
        $this->updateMemberPassword->update($membership->getId(), $password);
    }

    private function setUseNewDashboard($membership)
    {
        $this->connection->update(
            'members',
            ['use_new_dashboard' => 1],
            ['member_id' => $membership->getId()],
        );
    }
}
