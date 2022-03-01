<?php
declare(strict_types=1);

namespace AMB\Communication\Member;

use AMB\Communication\MemberCommunication;
use AMB\Entity\Member;

final class UpcomingVehicleRenewalCommunication extends MemberCommunication
{
    public function dispatch(Member $member, array $postcards)
    {
        $this->setValuesFromMember($member);
        $this->context
            ->addToContext('postcard_fee', $postcards);
        $this->send();

        return true;
    }

    protected function getTemplates(): array
    {
        return [
            'email' => [
                'html' => 'member.vehicle.upcoming-renewal',
            ],
        ];
    }
}
