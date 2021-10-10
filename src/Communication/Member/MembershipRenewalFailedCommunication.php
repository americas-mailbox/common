<?php
declare(strict_types=1);

namespace AMB\Communication\Member;

use AMB\Communication\MemberCommunication;
use AMB\Entity\Member;
use AMB\Interactor\FormatMoney;
use App\Log\Description\MembershipRenewalFailedEvent;
use IamPersistent\SimpleShop\Entity\PaymentMethodInterface;
use Money\Money;

final class MembershipRenewalFailedCommunication extends MemberCommunication
{
    protected ?string $activityLogFormatter = MembershipRenewalFailedEvent::class;

    public function dispatch(Member $member, Money $amount, PaymentMethodInterface $paymentMethod, string $message)
    {
        $this->setValuesFromMember($member);

        $amount = (new FormatMoney)($amount);
        $paymentExplanation = $paymentMethod->getDisplaySummary();
        $planTitle = $member->getMemberPlan()->getPlan()->getTitle();
        $this->context
            ->addToContext('amount', $amount)
            ->addToContext('failureMessage', $message)
            ->addToContext('paymentExplanation', $paymentExplanation)
            ->addToContext('planTitle', $planTitle);

        $this->send();

        return true;
    }

    protected function getTemplates(): array
    {
        return [
            'email' => [
                'html' => 'member.account.renewal-failed'
            ],
        ];
    }
}
