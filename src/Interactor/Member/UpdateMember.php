<?php
declare(strict_types=1);

namespace AMB\Interactor\Member;

use AMB\Entity\Member;
use AMB\Interactor\Account\UpdateAccount;
use AMB\Interactor\Db\BoolToSQL;
use AMB\Interactor\Ledger\SaveLedger;
use App\Authentication\Entity\NewAuthLookup;
use App\Authentication\Interactor\CreateAuthLookup;
use App\Authentication\Interactor\UpdateAuthLookup;
use Doctrine\DBAL\Connection;
use Hashids\Hashids;

final class UpdateMember
{
    private Hashids $hashids;

    public function __construct(
        private Connection $connection,
        private CreateAuthLookup $createAuthLookup,
        private SaveLedger $saveLedger,
        private UpdateAccount $updateAccount,
        private UpdateAuthLookup $updateAuthLookup,
    ) {
        $alphabet = getenv('HASH_IDS_ALPHABET');
        $length = (int) getenv('HASH_IDS_LENGTH');
        $salt = getenv('HASH_IDS_SALT');

        $this->hashids = new Hashids($salt, $length, $alphabet);
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
        $this->updateAuthLookup($member);
    }

    private function updateAuthLookup(Member $member): void
    {
        $email = $member->getEmail();
        $previousEmail = $member->getPreviousEmail();
        $this->handleAuthLookup($email, $previousEmail, $member);

        $altEmail = $member->getAlternateEmail();
        $previousAltEmail = $member->getPreviousAltEmail();
        $this->handleAuthLookup($altEmail, $previousAltEmail, $member);
    }

    private function handleAuthLookup(string $email, ?string $previousEmail, Member $member): void
    {
        if (!$previousEmail) {
            $newAuthLookup = new NewAuthLookup(
                $email,
                'changeMe',
                $member->getPMB(),
            );
            $id = $this->createAuthLookup->create($newAuthLookup);
            $userId = $this->hashids->encode($member->getId());
            $this->updateAuthLookup->update($id, ['user_id' => $userId]);

            return;
        }

        if ($email !== $previousEmail) {
            $this->connection->update('member_auth_lookups', ['email' => $email], ['email' => $previousEmail]);
        }
    }
}
