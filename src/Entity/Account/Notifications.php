<?php
declare(strict_types=1);

namespace AMB\Entity\Account;

use AMB\Interactor\RapidCityTime;

final class Notifications
{
    private int $lowBalanceNotificationCount;
    /** @var RapidCityTime[] */
    private array $lowBalanceNotificationDates;
    private string $reasonForSuspension;
    private int $suspendedNotificationCount;
    /** @var RapidCityTime[] */
    private array $suspendedNotificationDates;
    private array $suspensionCodes;

    public function getLowBalanceNotificationCount(): int
    {
        return $this->lowBalanceNotificationCount;
    }

    public function setLowBalanceNotificationCount(int $lowBalanceNotificationCount): Notifications
    {
        $this->lowBalanceNotificationCount = $lowBalanceNotificationCount;

        return $this;
    }

    public function getLowBalanceNotificationDates(): array
    {
        return $this->lowBalanceNotificationDates;
    }

    public function setLowBalanceNotificationDates(array $lowBalanceNotificationDates): Notifications
    {
        $this->lowBalanceNotificationDates = $lowBalanceNotificationDates;

        return $this;
    }

    public function clearReasonForSuspension(): Notifications
    {
        $this->reasonForSuspension = '';

        return $this;
    }

    public function getReasonForSuspension(): string
    {
        return $this->reasonForSuspension;
    }

    public function setReasonForSuspension(string $reasonForSuspension): Notifications
    {
        $this->reasonForSuspension = $reasonForSuspension;

        return $this;
    }

    public function getSuspendedNotificationDates(): array
    {
        return $this->suspendedNotificationDates;
    }

    public function setSuspendedNotificationDates(array $suspendedNotificationDates): Notifications
    {
        $this->suspendedNotificationDates = $suspendedNotificationDates;

        return $this;
    }

    public function getSuspendedNotificationCount(): int
    {
        return $this->suspendedNotificationCount;
    }

    public function setSuspendedNotificationCount(int $suspendedNotificationCount): Notifications
    {
        $this->suspendedNotificationCount = $suspendedNotificationCount;

        return $this;
    }

    public function getSuspensionCodes(): array
    {
        return $this->suspensionCodes;
    }

    public function setSuspensionCodes(array $suspensionCodes): Notifications
    {
        $this->suspensionCodes = $suspensionCodes;

        return $this;
    }
}
