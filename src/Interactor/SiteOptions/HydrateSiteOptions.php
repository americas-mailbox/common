<?php
declare(strict_types=1);

namespace AMB\Interactor\SiteOptions;

use AMB\Entity\SiteOptions;
use AMB\Interactor\RapidCityTime;
use Communication\Recipient;
use OLPS\Money\ArrayToMoney;
use IamPersistent\SwiftMailer\Context\PartyContext;
use Money\Money;

final class HydrateSiteOptions
{
    public function __invoke(array $data): SiteOptions
    {
        $fromRecipient = (new Recipient())
            ->setEmail($data['fromEmailAddress'])
            ->setName('Americas Mailbox');

        $siteOptions = (new SiteOptions())
            ->setAdminCutOffTime(new RapidCityTime($data['adminCutOffTime']))
            ->setAutoRenewalNotificationDays($data['autoRenewalNotificationDays'])
            ->setConvenienceFee((float)$data['convenienceFee'])
            ->setConvenienceBaseFee($this->hydrateMoney($data['convenienceBaseFee']))
            ->setCriticalBalanceAmount($this->hydrateMoney($data['criticalBalanceAmount']))
            ->setCriticalBalanceReason($data['criticalBalanceReason'])
            ->setCutOffTime(new RapidCityTime($data['cutOffTime']))
            ->setExpirationWarningEmailDays($data['expirationWarningEmailDays'])
            ->setFromRecipient($fromRecipient)
            ->setFreeInteriorScanPages((int) $data['freeInteriorScanPages'])
            ->setInteriorScanSKU($data['interiorScanSKU'])
            ->setInteriorScanPageSKU($data['interiorScanPageSKU'])
            ->setLowBalanceEmailFrequency((int)$data['lowBalanceEmailFrequency'])
            ->setMaximumLowBalanceNotifications((int)$data['maximumLowBalanceNotifications'])
            //         ->setMinimumAllowedBalance($this->hydrateMoney($data['minimumAllowedBalance']))
            ->setOfficeClosingTime(new RapidCityTime($data['officeClosingTime']))
            ->setOfficeOpeningTime(new RapidCityTime($data['officeOpeningTime']))
            ->setSpecialAccountPMBs($data['specialAccountPMBs'])
            ->setStaffDailyEmailTime(new RapidCityTime($data['staffDailyEmailTime']))
            ->setTaxRate((float)$data['taxRate'])
//            ->setTimeToRenew(CarbonInterval::fromString($data['timeToRenew']))
            ->setTopUpAmount($this->hydrateMoney($data['topUpAmount']))
            ->setVehicleWarningEmailDays($data['vehicleWarningEmailDays']);

        if (!class_exists(PartyContext::class)) {
            return $siteOptions;
        }
        $bccEmailAddresses = [];
        $bccRecipients = [];
        if (isset($data['bccEmailAddresses'])) {
            foreach ($data['bccEmailAddresses'] as $emailAddress) {
                if (empty($emailAddress)) {
                    continue;
                }
                $bccRecipients[] = (new Recipient())->setEmail($emailAddress);
                $bccEmailAddresses[] = new PartyContext($emailAddress);
            }
        }

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

        $siteOptions
            ->setBccEmailAddresses($bccEmailAddresses)
            ->setBccRecipients($bccRecipients)
            ->setFromEmailAddress(new PartyContext($data['fromEmailAddress'], 'Americas Mailbox'))
            ->setSiteSenderEmail(new PartyContext($data['siteSenderEmail']))
            ->setStaffNotificationRecipients($staffNotificationRecipients)
            ->setSystemFailureNotificationRecipients($systemFailureNotificationRecipients);

        return $siteOptions;
    }

    private function hydrateMoney($money): Money
    {
        return (new ArrayToMoney)($money);
    }
}
