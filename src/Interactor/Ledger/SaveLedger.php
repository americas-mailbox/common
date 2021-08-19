<?php
declare(strict_types=1);

namespace AMB\Interactor\Ledger;

use AMB\Entity\Member;
use AMB\Entity\MemberStatus;
use AMB\Interactor\Member\SuspendMember;
use AMB\Interactor\Member\UnsuspendMember;
use IamPersistent\Ledger\Entity\Ledger;
use IamPersistent\Ledger\Interactor\DBal\SaveLedger as DbalSaveLedger;

final class SaveLedger
{
    /** @var \IamPersistent\Ledger\Interactor\DBal\SaveLedger */
    private $saveLedger;
    /** @var \AMB\Interactor\Member\UnsuspendMember */
    private $unsuspendMember;

    public function __construct(
        DbalSaveLedger $saveLedger,
        UnsuspendMember $unsuspendMember
    ) {
        $this->saveLedger = $saveLedger;
        $this->unsuspendMember = $unsuspendMember;
    }

    public function save(Ledger $ledger, Member $member)
    {
        $this->saveLedger->save($ledger);
        $member->getAccount()->setLedger($ledger);
        if ($member->isSuspended()) {
            $this->handledSuspendedMember($member, $ledger);
        }

        return true;
    }

    private function handledSuspendedMember(Member $member, Ledger $ledger)
    {
        if ($member->getMemberStatus()->getValue() === MemberStatus::UNVERIFIED) {
            return;
        }
        if ($ledger->getBalance()->greaterThan($member->getAccount()->getCriticalBalance())) {
            $this->unsuspendMember->handle($member);
        }
    }
}
