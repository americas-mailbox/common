<?php
declare(strict_types=1);

namespace AMB\Interactor\SiteOptions;

use AMB\Entity\SiteOptions;
use AMB\Interactor\RapidCityTime;
use Communication\Recipient;
use IamPersistent\Money\Interactor\ArrayToMoney;
use IamPersistent\SwiftMailer\Context\PartyContext;
use Money\Money;

final class HydrateSiteOptions
{
    public function __invoke(array $data): SiteOptions
    {
        $bccEmailAddresses = [];
        $bccRecipients = [];
        if (isset($data['bccEmailAddresses'])) {
            foreach ($data['bccEmailAddresses'] as $emailAddress) {
                $bccRecipients[] = (new Recipient())->setEmail($emailAddress);
                $bccEmailAddresses[] = new PartyContext($emailAddress);
            }
        }
        $fromRecipient = (new Recipient())
            ->setEmail($data['fromEmailAddress'])
            ->setName('Americas Mailbox');

        $staffNotificationRecipients = [];
        if (isset($data['staffNotificationRecipients'])) {
            foreach ($data['staffNotificationRecipients'] as $emailAddress) {
                $staffNotificationRecipients[] = new PartyContext($emailAddress);
            }
        }

        $systemFailureNotificationRecipients = [];
        if (isset($data['systemFailureNotificationRecipients'])) {
            foreach ($data['systemFailureNotificationRecipients'] as $emailAddress) {
                $systemFailureNotificationRecipients[] = new PartyContext($emailAddress);
            }
        }

        return (new SiteOptions())
            ->setAdminCutOffTime(new RapidCityTime($data['adminCutOffTime']))
            ->setBccEmailAddresses($bccEmailAddresses)
            ->setBccRecipients($bccRecipients)
            ->setAutoRenewalNotificationDays($data['autoRenewalNotificationDays'])
            ->setConvenienceFee((float)$data['convenienceFee'])
            ->setConvenienceBaseFee($this->hydrateMoney($data['convenienceBaseFee']))
            ->setCriticalBalanceAmount($this->hydrateMoney($data['criticalBalanceAmount']))
            ->setCriticalBalanceReason($data['criticalBalanceReason'])
            ->setCutOffTime(new RapidCityTime($data['cutOffTime']))
            ->setFromEmailAddress(new PartyContext($data['fromEmailAddress'], 'Americas Mailbox'))
            ->setFromRecipient($fromRecipient)
            ->setExpirationWarningEmailDays($data['expirationWarningEmailDays'])
            ->setLowBalanceEmailFrequency((int)$data['lowBalanceEmailFrequency'])
            ->setMaximumLowBalanceNotifications((int)$data['maximumLowBalanceNotifications'])
            //         ->setMinimumAllowedBalance($this->hydrateMoney($data['minimumAllowedBalance']))
            ->setOfficeClosingTime(new RapidCityTime($data['officeClosingTime']))
            ->setOfficeOpeningTime(new RapidCityTime($data['officeOpeningTime']))
            ->setSiteSenderEmail(new PartyContext($data['siteSenderEmail']))
            ->setSpecialAccountPMBs($data['specialAccountPMBs'])
            ->setStaffDailyEmailTime(new RapidCityTime($data['staffDailyEmailTime']))
            ->setStaffNotificationRecipients($staffNotificationRecipients)
            ->setSystemFailureNotificationRecipients($systemFailureNotificationRecipients)
            ->setTaxRate((float)$data['taxRate'])
//            ->setTimeToRenew(CarbonInterval::fromString($data['timeToRenew']))
            ->setTopUpAmount($this->hydrateMoney($data['topUpAmount']))
            ->setVehicleWarningEmailDays($data['vehicleWarningEmailDays']);
    }

    private function hydrateMoney($money): Money
    {
        return (new ArrayToMoney)($money);
    }
}
