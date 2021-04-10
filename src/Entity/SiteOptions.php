<?php
declare(strict_types=1);

namespace AMB\Entity;

use Carbon\Carbon;
use Carbon\CarbonInterval;
use DateTime;
use IamPersistent\SwiftMailer\Context\PartyContext;
use JsonSerializable;
use Money\Money;
use Notification\Recipient;

final class SiteOptions implements JsonSerializable
{
    /** @var Carbon */
    private $adminCutOffTime;
    /** @var int[] */
    private $autoRenewalNotificationDays;
    /** @var PartyContext[] */
    private $bccEmailAddresses;
    /** @var \Notification\Recipient[] */
    private $bccRecipients;
    /** @var float */
    private $convenienceFee;
    /** @var Money */
    private $convenienceBaseFee;
    /** @var Money */
    private $criticalBalanceAmount;
    /** @var string */
    private $criticalBalanceReason;
    /** @var Carbon */
    private $cutOffTime;
    /** @var PartyContext */
    private $fromEmailAddress;
    /** @var \Notification\Recipient */
    private $fromRecipient;
    /** @var int[] */
    private $expirationWarningEmailDays = [];
    /** @var int */
    private $lowBalanceEmailFrequency;
    /** @var int */
    private $maximumLowBalanceNotifications;
    /** @var Money */
    private $minimumAllowedBalance;
    /** @var Carbon */
    private $officeClosingTime;
    /** @var Carbon */
    private $officeOpeningTime;
    /** @var PartyContext */
    private $siteSenderEmail;
    /** @var string[] */
    private $specialAccountPMBs = [];
    /** @var Carbon */
    private $staffDailyEmailTime;
    /** @var PartyContext[] */
    private $staffNotificationRecipients = [];
    /** @var PartyContext[] */
    private $systemFailureNotificationRecipients = [];
    /** @var float */
    private $taxRate = .065;
    /** @var CarbonInterval */
    private $timeToRenew;
    /** @var Money */
    private $topUpAmount;
    /** @var int[] */
    private $vehicleWarningEmailDays = [];

    public function getAdminCutOffTime(): Carbon
    {
        return $this->adminCutOffTime;
    }

    public function setAdminCutOffTime(Carbon $adminCutOffTime): SiteOptions
    {
        $this->adminCutOffTime = $adminCutOffTime;

        return $this;
    }

    public function getAutoRenewalNotificationDays(): array
    {
        return $this->autoRenewalNotificationDays;
    }

    public function setAutoRenewalNotificationDays(array $autoRenewalNotificationDays): SiteOptions
    {
        $this->autoRenewalNotificationDays = [];
        foreach ($autoRenewalNotificationDays as $day) {
            $this->autoRenewalNotificationDays[] = (int) $day;
        }

        return $this;
    }

    public function getBccEmailAddresses(): ?array
    {
        return $this->bccEmailAddresses;
    }

    public function setBccEmailAddresses(array $bccEmailAddresses): SiteOptions
    {
        $this->bccEmailAddresses = $bccEmailAddresses;

        return $this;
    }

    public function getBccRecipients(): array
    {
        return $this->bccRecipients;
    }

    public function setBccRecipients(array $bccRecipients): SiteOptions
    {
        $this->bccRecipients = $bccRecipients;

        return $this;
    }

    public function getConvenienceFee(): float
    {
        return $this->convenienceFee;
    }

    public function setConvenienceFee(float $convenienceFee): SiteOptions
    {
        $this->convenienceFee = $convenienceFee;

        return $this;
    }

    public function getConvenienceBaseFee(): Money
    {
        return $this->convenienceBaseFee;
    }

    public function setConvenienceBaseFee(Money $convenienceBaseFee): SiteOptions
    {
        $this->convenienceBaseFee = $convenienceBaseFee;

        return $this;
    }

    public function getCriticalBalanceAmount(): Money
    {
        return $this->criticalBalanceAmount;
    }

    public function setCriticalBalanceAmount(Money $criticalBalanceAmount): SiteOptions
    {
        $this->criticalBalanceAmount = $criticalBalanceAmount;

        return $this;
    }

    public function getCriticalBalanceReason(): string
    {
        return $this->criticalBalanceReason;
    }

    public function setCriticalBalanceReason(string $criticalBalanceReason): SiteOptions
    {
        $this->criticalBalanceReason = $criticalBalanceReason;

        return $this;
    }

    public function getCutOffTime(): Carbon
    {
        return $this->cutOffTime;
    }

    public function setCutOffTime(Carbon $cutOffTime): SiteOptions
    {
        $this->cutOffTime = $cutOffTime;

        return $this;
    }

    public function getFromEmailAddress(): PartyContext
    {
        return $this->fromEmailAddress;
    }

    public function setFromEmailAddress(PartyContext $fromEmailAddress): SiteOptions
    {
        $this->fromEmailAddress = $fromEmailAddress;

        return $this;
    }

    public function getFromRecipient(): Recipient
    {
        return $this->fromRecipient;
    }

    public function setFromRecipient(Recipient $fromRecipient): SiteOptions
    {
        $this->fromRecipient = $fromRecipient;

        return $this;
    }

    public function getExpirationWarningEmailDays(): array
    {
        return $this->expirationWarningEmailDays;
    }

    public function setExpirationWarningEmailDays(array $expirationWarningEmailDays): SiteOptions
    {
        $this->expirationWarningEmailDays = [];
        foreach ($expirationWarningEmailDays as $day) {
            $this->expirationWarningEmailDays[] = (int) $day;
        }

        return $this;
    }

    public function formatDate(DateTime $date): string
    {
        return Carbon::instance($date)->toDateString();
    }

    public function getLowBalanceEmailFrequency(): int
    {
        return $this->lowBalanceEmailFrequency;
    }

    public function setLowBalanceEmailFrequency(int $lowBalanceEmailFrequency): SiteOptions
    {
        $this->lowBalanceEmailFrequency = $lowBalanceEmailFrequency;

        return $this;
    }

    public function getMaximumLowBalanceNotifications(): int
    {
        return $this->maximumLowBalanceNotifications;
    }

    public function setMaximumLowBalanceNotifications(int $maximumLowBalanceNotifications): SiteOptions
    {
        $this->maximumLowBalanceNotifications = $maximumLowBalanceNotifications;

        return $this;
    }

    public function getOfficeClosingTime(): Carbon
    {
        return $this->officeClosingTime;
    }

    public function setOfficeClosingTime(Carbon $officeClosingTime): SiteOptions
    {
        $this->officeClosingTime = $officeClosingTime;

        return $this;
    }

    public function getOfficeOpeningTime(): Carbon
    {
        return $this->officeOpeningTime;
    }

    public function setOfficeOpeningTime(Carbon $officeOpeningTime): SiteOptions
    {
        $this->officeOpeningTime = $officeOpeningTime;

        return $this;
    }

    public function getSiteSenderEmail(): ?PartyContext
    {
        return $this->siteSenderEmail;
    }

    public function setSiteSenderEmail(PartyContext $siteSenderEmail): SiteOptions
    {
        $this->siteSenderEmail = $siteSenderEmail;

        return $this;
    }

    public function getSpecialAccountPMBs(): array
    {
        return $this->specialAccountPMBs;
    }

    public function setSpecialAccountPMBs(array $specialAccountPMBs): SiteOptions
    {
        $this->specialAccountPMBs = $specialAccountPMBs;

        return $this;
    }

    public function getStaffDailyEmailTime(): Carbon
    {
        return $this->staffDailyEmailTime;
    }

    public function setStaffDailyEmailTime(Carbon $staffDailyEmailTime): SiteOptions
    {
        $this->staffDailyEmailTime = $staffDailyEmailTime;

        return $this;
    }

    public function getStaffNotificationRecipients(): array
    {
        return $this->staffNotificationRecipients;
    }

    public function setStaffNotificationRecipients(array $staffNotificationRecipients): SiteOptions
    {
        $this->staffNotificationRecipients = $staffNotificationRecipients;

        return $this;
    }

    public function getSystemFailureNotificationRecipients(): array
    {
        return $this->systemFailureNotificationRecipients;
    }

    public function setSystemFailureNotificationRecipients(array $systemFailureNotificationRecipients): SiteOptions
    {
        $this->systemFailureNotificationRecipients = $systemFailureNotificationRecipients;

        return $this;
    }

    public function getTaxRate(): float
    {
        return $this->taxRate;
    }

    public function setTaxRate(float $taxRate): SiteOptions
    {
        $this->taxRate = $taxRate;

        return $this;
    }

    public function getTimeToRenew(): CarbonInterval
    {
        return CarbonInterval::create(0, -1, 0, -2);
        //        return $this->timeToRenew;
    }

    public function setTimeToRenew(CarbonInterval $timeToRenew): SiteOptions
    {
        $this->timeToRenew = $timeToRenew;

        return $this;
    }

    public function getTopUpAmount(): Money
    {
        return $this->topUpAmount;
    }

    public function setTopUpAmount(Money $topUpAmount): SiteOptions
    {
        $this->topUpAmount = $topUpAmount;

        return $this;
    }

    public function getVehicleWarningEmailDays(): array
    {
        return $this->vehicleWarningEmailDays;
    }

    public function setVehicleWarningEmailDays(array $vehicleWarningEmailDays): SiteOptions
    {
        $this->vehicleWarningEmailDays = [];
        foreach ($vehicleWarningEmailDays as $day) {
            $this->vehicleWarningEmailDays[] = (int) $day;
        }
        $this->vehicleWarningEmailDays = $vehicleWarningEmailDays;

        return $this;
    }

    public function jsonSerialize()
    {
        return $this->toArray();
    }

    public function toArray(): array
    {
        return [
            'adminCutOffTime'                     => $this->adminCutOffTime->toTimeString(),
            'convenienceFee'                      => $this->convenienceFee,
            'convenienceBaseFee'                  => $this->convenienceBaseFee,
            'criticalBalanceAmount'               => $this->criticalBalanceAmount,
            'criticalBalanceReason'               => $this->criticalBalanceReason,
            'cutOffTime'                          => $this->cutOffTime->toTimeString(),
            'emailNotification'                   => $this->emailNotification,
            'expirationWarningEmailDays'          => $this->expirationWarningEmailDays,
            'lowBalanceEmailFrequency'            => $this->lowBalanceEmailFrequency,
            'maximumLowBalanceNotifications'      => $this->maximumLowBalanceNotifications,
            'minimumAllowedBalance'               => $this->minimumAllowedBalance,
            'officeClosingTime'                   => $this->officeClosingTime->toTimeString(),
            'officeOpeningTime'                   => $this->officeOpeningTime->toTimeString(),
            'siteSenderEmail'                     => $this->siteSenderEmail,
            'specialAccountPMBs'                  => $this->specialAccountPMBs,
            'staffDailyEmailTime'                 => $this->staffDailyEmailTime->toTimeString(),
            'staffNotificationRecipients'         => $this->staffNotificationRecipients,
            'systemFailureNotificationRecipients' => $this->systemFailureNotificationRecipients,
            'taxRate'                             => $this->taxRate,
            'timeToRenew'                         => $this->timeToRenew,
            'topUpAmount'                         => $this->topUpAmount,
            'vehicleWarningEmailDays'             => $this->vehicleWarningEmailDays,
        ];
    }
}
