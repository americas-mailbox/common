<?php
declare(strict_types=1);

namespace AMB\Entity\Account;

use AMB\Interactor\RapidCityTime;

final class Notifications
{
    private ?RapidCityTime $lastLowBalanceNotificationDate;
    private ?RapidCityTime $lastSuspendedNotificationDate;
    private int $lowBalanceNotificationCount;
    private string $reasonForSuspension;
    private int $suspendedNotificationCount;
    private array $suspensionCodes;

    public function getLastLowBalanceNotificationDate(): ?RapidCityTime
    {
        return $this->lastLowBalanceNotificationDate;
    }

    public function setLastLowBalanceNotificationDate(?RapidCityTime $lastLowBalanceNotificationDate): Notifications
    {
        $this->lastLowBalanceNotificationDate = $lastLowBalanceNotificationDate;

        return $this;
    }

    public function getLastSuspendedNotificationDate(): ?RapidCityTime
    {
        return $this->lastSuspendedNotificationDate;
    }

    public function setLastSuspendedNotificationDate(?RapidCityTime $lastSuspendedNotificationDate): Notifications
    {
        $this->lastSuspendedNotificationDate = $lastSuspendedNotificationDate;

        return $this;
    }

    public function getLowBalanceNotificationCount(): int
    {
        return $this->lowBalanceNotificationCount;
    }

    public function setLowBalanceNotificationCount(int $lowBalanceNotificationCount): Notifications
    {
        $this->lowBalanceNotificationCount = $lowBalanceNotificationCount;

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
