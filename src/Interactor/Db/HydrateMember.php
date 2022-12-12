<?php
declare(strict_types=1);

namespace AMB\Interactor\Db;

use AMB\Entity\Member;
use AMB\Entity\Member\Plan;
use AMB\Entity\MemberStatus;
use AMB\Entity\RenewalFrequency;
use AMB\Interactor\Plan\FindPlanById;
use AMB\Interactor\RapidCityTime;

final class HydrateMember
{
    public function __construct(
        private FindPlanById $findPlanById,
        private HydrateAccount $hydrateAccount,
    ) {
    }

    public function hydrate(array $memberData): Member
    {
        $accountData = $memberData;
        $accountData['id'] = $memberData['account_id'];
        $account = $this->hydrateAccount->hydrate($accountData);

        $email = $memberData['email'] ?? '';

        $plan = $this->hydratePlan($memberData);
        $sqlToBool = new SQLToBool();

        $member = (new Member())
            ->setActive(new MemberStatus((int) $memberData['active']))
            ->setAccount($account)
            ->setAlternateEmail($memberData['alt_email'])
            ->setAlternateName($memberData['alternate_name'])
            ->setAlternatePhone($memberData['alt_phone'])
            ->setComment($memberData['comment'])
            ->setEmail($email)
            ->setFirstName($memberData['first_name'] ?? '')
            ->setId((int)$memberData['member_id'])
            ->setLastName($memberData['last_name'] ?? '')
            ->setMiddleName($memberData['middle_name'] ?? '')
            ->setPIN($memberData['pin'])
            ->setMemberPlan($plan)
            ->setPhone($memberData['phone'])
            ->setPMB($memberData['pmb'] ? (string)$memberData['pmb'] : null)
            ->setShippingInstructions($memberData['shipinst'])
            ->setSuffix($memberData['suffix'])
            ->setSuspended($sqlToBool($memberData['suspended']))
            ->setUseNewDashboard($sqlToBool($memberData['use_new_dashboard']));
        if (!empty($memberData['renewDate'])) {
            $member->setRenewDate(new RapidCityTime($memberData['renewDate']));
        }
        if (!empty($memberData['return_to_sender_date'])) {
            $member->setReturnToSenderDate(new RapidCityTime($memberData['return_to_sender_date']));
        }
        if (!empty($memberData['startDate'])) {
            $member->setStartDate(new RapidCityTime($memberData['startDate']));
        }

        return $member;
    }

    private function hydratePlan(array $memberData): ?Plan
    {
        if (empty($memberData['level_id'])) {
            return null;
        }
        $ambPlan = $this->findPlanById->find((int) $memberData['level_id']);
        $renewalFrequency = new RenewalFrequency($memberData['renewal_frequency']);
        $renewsOn = new RapidCityTime($memberData['renewDate']);

        return (new Plan())
            ->setPlan($ambPlan)
            ->setRenewalFrequency($renewalFrequency)
            ->setRenewsOn($renewsOn);
    }
}
