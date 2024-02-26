<?php
declare(strict_types=1);

namespace AMB\Entity\Shipping;

use AMB\Entity\Address;
use AMB\Entity\LegacyMember;
use AMB\Interactor\RapidCityTime;

final class ShippingEvent
{
    /** @var Address|null */
    private $address;
    /** @var bool */
    private $active;
    /** @var bool */
    private $daily = false;
    /** @var int|null */
    private $dayOfTheMonth;
    /** @var DayOfTheWeek|null */
    private $dayOfTheWeek;
    /** @var DeliveryMethod */
    private $deliveryMethod;
    /** @var \AMB\Interactor\RapidCityTime */
    private $endDate;
    /** @var DayOfTheWeek|null */
    private $firstWeekdayOfTheMonth;
    private ?int $id = null;
    /** @var DayOfTheWeek|null */
    private $lastWeekdayOfTheMonth;
    /** @var \AMB\Entity\LegacyMember */
    private $member;
    /** @var \AMB\Interactor\RapidCityTime|null */
    private $nextWeekly;
    /** @var \AMB\Entity\Shipping\RecurrenceType */
    private $recurrenceType;
    /** @var \AMB\Interactor\RapidCityTime */
    private $startDate;
    /** @var int|null */
    private $weeksBetween;

    public function getAddress(): ?Address
    {
        return $this->address;
    }

    public function setAddress(Address $address): ShippingEvent
    {
        $this->address = $address;

        return $this;
    }

    public function isActive(): bool
    {
        return $this->active;
    }

    public function setActive(bool $active): ShippingEvent
    {
        $this->active = $active;

        return $this;
    }

    public function isDaily(): bool
    {
        return $this->daily;
    }

    public function setDaily(bool $daily): ShippingEvent
    {
        $this->daily = $daily;

        return $this;
    }

    public function getDayOfTheMonth(): ?int
    {
        return $this->dayOfTheMonth;
    }

    public function setDayOfTheMonth(?int $dayOfTheMonth): ShippingEvent
    {
        $this->dayOfTheMonth = $dayOfTheMonth;

        return $this;
    }

    public function getDayOfTheWeek(): ?DayOfTheWeek
    {
        return $this->dayOfTheWeek;
    }

    public function setDayOfTheWeek(?DayOfTheWeek $dayOfTheWeek): ShippingEvent
    {
        $this->dayOfTheWeek = $dayOfTheWeek;

        return $this;
    }

    public function getDeliveryMethod(): DeliveryMethod
    {
        return $this->deliveryMethod;
    }

    public function setDeliveryMethod(DeliveryMethod $deliveryMethod): ShippingEvent
    {
        $this->deliveryMethod = $deliveryMethod;

        return $this;
    }

    public function getEndDate(): RapidCityTime
    {
        return $this->endDate;
    }

    public function setEndDate(RapidCityTime $endDate): ShippingEvent
    {
        $this->endDate = $endDate;

        return $this;
    }

    public function getFirstWeekdayOfTheMonth(): ?DayOfTheWeek
    {
        return $this->firstWeekdayOfTheMonth;
    }

    public function setFirstWeekdayOfTheMonth(?DayOfTheWeek $firstWeekdayOfTheMonth): ShippingEvent
    {
        $this->firstWeekdayOfTheMonth = $firstWeekdayOfTheMonth;

        return $this;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setId(int $id): ShippingEvent
    {
        $this->id = $id;

        return $this;
    }

    public function getLastWeekdayOfTheMonth(): ?DayOfTheWeek
    {
        return $this->lastWeekdayOfTheMonth;
    }

    public function setLastWeekdayOfTheMonth(?DayOfTheWeek $lastWeekdayOfTheMonth): ShippingEvent
    {
        $this->lastWeekdayOfTheMonth = $lastWeekdayOfTheMonth;

        return $this;
    }

    public function getMember(): LegacyMember
    {
        return $this->member;
    }

    public function setMember(LegacyMember $member): ShippingEvent
    {
        $this->member = $member;

        return $this;
    }

    public function getNextWeekly(): ?RapidCityTime
    {
        return $this->nextWeekly;
    }

    public function setNextWeekly(?RapidCityTime $nextWeekly): ShippingEvent
    {
        $this->nextWeekly = $nextWeekly;

        return $this;
    }

    public function isPickup(): bool
    {
        return 'pickup' === $this->deliveryMethod->getGroup();
    }

    public function isRecurring(): bool
    {
        return !$this->getRecurrenceType()->equals(RecurrenceType::DOES_NOT_REPEAT());
    }

    public function getRecurrenceType(): RecurrenceType
    {
        return $this->recurrenceType;

        if (true === $this->daily) {
            return RecurrenceType::DAILY();
        }
        if ($this->nextWeekly) {
            return RecurrenceType::INTERMITTENT();
        }
        if ($this->weeksBetween === 1) {
            return RecurrenceType::WEEKLY();
        }
        if (!empty($this->firstWeekdayOfTheMonth)) {
            return RecurrenceType::FIRST_WEEKDAY_OF_MONTH();
        }
        if (!empty($this->lastWeekdayOfTheMonth)) {
            return RecurrenceType::LAST_WEEKDAY_OF_MONTH();
        }
        if (!empty($this->dayOfTheMonth)) {
            return RecurrenceType::MONTHLY();
        }

        return RecurrenceType::DOES_NOT_REPEAT();
    }

    public function setRecurrenceType(RecurrenceType $recurrenceType): ShippingEvent
    {
        $this->recurrenceType = $recurrenceType;

        return $this;
    }

    public function getStartDate(): RapidCityTime
    {
        return $this->startDate;
    }

    public function setStartDate(RapidCityTime $startDate): ShippingEvent
    {
        $this->startDate = $startDate;

        return $this;
    }

    public function getWeeksBetween(): ?int
    {
        return $this->weeksBetween;
    }

    public function setWeeksBetween(?int $weeksBetween): ShippingEvent
    {
        $this->weeksBetween = $weeksBetween;

        return $this;
    } // every x weeks
}
