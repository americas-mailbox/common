<?php
declare(strict_types=1);

namespace AMB\Entity\Account;

final class Notifications
{
    /** @var \AMB\Interactor\RapidCityTime[] */
    private $lowBalanceNotificationDates;
    /** @var int */
    private $lowBalanceNotificationCount;
    /** @var string */
    private $reasonForSuspension;
    /** @var int */
    private $suspendedNotificationCount;

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

    public function getLowBalanceNotificationCount(): int
    {
        return $this->lowBalanceNotificationCount;
    }

    public function setLowBalanceNotificationCount(int $lowBalanceNotificationCount): Notifications
    {
        $this->lowBalanceNotificationCount = $lowBalanceNotificationCount;

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
}
