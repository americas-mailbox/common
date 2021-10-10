<?php
declare(strict_types=1);

namespace AMB\Communication\Member;

use AMB\Communication\MemberCommunication;
use AMB\Entity\Member;
use AMB\Entity\RenewalFrequency;
use AMB\Interactor\FormatMoney;
use App\Log\Description\MembershipRenewedEvent;
use IamPersistent\SimpleShop\Entity\Invoice;

final class MembershipRenewedCommunication extends MemberCommunication
{
    protected ?string $activityLogFormatter = MembershipRenewedEvent::class;

    public function dispatch(Member $member, Invoice $invoice)
    {
        $this->setValuesFromMember($member);

        $amount = (new FormatMoney)($invoice->getTotal());
        $paymentExplanation = $invoice->getPaid()->getPaymentMethod()->getDisplaySummary();
        $planTitle = $member->getMemberPlan()->getPlan()->getTitle();
        $timeOfRenewal = $this->getTimeOfRenewal($member->getMemberPlan()->getRenewalFrequency());
        $this->context
            ->addToContext('amount', $amount)
            ->addToContext('paymentExplanation', $paymentExplanation)
            ->addToContext('planTitle', $planTitle)
            ->addToContext('timeOfRenewal', $timeOfRenewal);

        $this->send();

        return true;
    }

    private function getTimeOfRenewal(RenewalFrequency $renewalFrequency): string
    {
        $time = [
            'annual'   => 'year',
            'biannual' => 'six months',
            'month'    => 'month',
            'quarter'  => 'three months',
        ];

        return $time[$renewalFrequency->getValue()];
    }

    protected function getTemplates(): array
    {
        return [
            'email' => [
                'html' => 'member.account.renewed',
            ],
        ];
    }
}
