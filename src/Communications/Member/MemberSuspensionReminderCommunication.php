<?php
declare(strict_types=1);

namespace AMB\Communications\Member;

use AMB\Communication\MemberCommunication;
use AMB\Entity\Member;

final class MemberSuspensionReminderCommunication extends MemberCommunication
{
    public function dispatch(Member $member, string $reasonForSuspension)
    {
        $this->setValuesFromMember($member);
        $this->context
            ->addToContext('reasonForSuspension', $reasonForSuspension);

        $this->send();

        return true;
    }

    protected function getTemplates(): array
    {
        return [
            'email' => [
                'html' => 'member.account.suspension-reminder'
            ],
        ];
     }
}
