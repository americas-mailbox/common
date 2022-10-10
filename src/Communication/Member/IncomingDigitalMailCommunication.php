<?php
declare(strict_types=1);

namespace AMB\Communication\Member;

use AMB\Communication\MemberCommunication;
use AMB\Entity\Member;

final class IncomingDigitalMailCommunication extends MemberCommunication
{
//    protected ?string $activityLogFormatter = MembershipRenewedEvent::class;

    public function dispatch(Member $member)
    {
        $this->setValuesFromMember($member);
        $this->context
            ->setSubject('You have mail');
        $this->send();

        return true;
    }

    protected function getTemplates(): array
    {
        return [
            'email' => [
                'html' => 'member.digital-mail.incoming',
            ],
        ];
    }
}
