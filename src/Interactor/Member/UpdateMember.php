<?php
declare(strict_types=1);

namespace AMB\Interactor\Member;

use AMB\Entity\Member;
use AMB\Interactor\Account\UpdateAccount;
use AMB\Interactor\Db\BoolToSQL;
use AMB\Interactor\Ledger\SaveLedger;
use Doctrine\DBAL\Connection;

final class UpdateMember
{
    public function __construct(
        private Connection $connection,
        private SaveLedger $saveLedger,
        private UpdateAccount $updateAccount,
    ) {
    }

    public function update(Member $member)
    {
        $this->saveLedger->save($member->getLedger(), $member);
        $this->updateAccount->update($member->getAccount());
        $data = [
            'active'       => $member->getActive()->getValue(),
            'alt_email'    => $member->getAlternateEmail(),
            'alt_phone'    => $member->getAlternatePhone(),
            'comment'      => $member->getComment(),
            'email'        => $member->getEmail(),
            'first_name'   => $member->getFirstName(),
            'last_name'    => $member->getLastName(),
            'middle_name'  => $member->getMiddleName(),
            'pin'          => $member->getPIN(),
            'phone'        => $member->getPhone(),
            'pmb'          => $member->getPMB(),
            'shipinst'     => $member->getShippingInstructions(),
            'startDate'    => $member->getStartDate()->format('Y-m-d'),
            'suspended'    => (new BoolToSQL)($member->isSuspended()),
            'suffix'       => $member->getSuffix(),
        ];
        if ($plan = $member->getMemberPlan()) {
            $data['level_id'] = $plan->getPlan()->getId();
            $data['renewal_frequency'] = $plan->getRenewalFrequency()->getValue();
            $data['renewDate'] = $plan->getRenewsOn()->toDateString();
        }
        $this->connection->update('members', $data, ['member_id' => $member->getId()]);
    }
}
