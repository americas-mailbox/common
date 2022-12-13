<?php
declare(strict_types=1);

namespace AMB\Interactor\ShippingEvent;

use AMB\Entity\Shipping\RecurrenceType;
use AMB\Entity\Shipping\ShippingEvent;
use AMB\Interactor\RapidCityTime;
use AMB\Interactor\Shipping\FindRecurringShippingEvent;
use AMB\Interactor\Shipping\GetNextDate;

final class DeleteEventsOnDay
{
    public function __construct(
        private DeleteDateInRecurringEvent $deleteDateInRecurringEvent,
        private DeleteOneTimeEvent $deleteOneTimeEvent,
        private FindRecurringShippingEvent $findShippingEvent,
        private GatherShippingEventsInRange $gatherShippingEventsInRange,
        private GetNextDate $getNextDate,
    ) {
    }

    public function delete(array $data)
    {
        $date = new RapidCityTime($data['date']);
        $events = $this->gatherEventsOnDate($data['memberId'], $date);
        foreach ($events as $event) {
            $this->deleteDate($event, $date);
        }
        $this->deletedDateAdjustedEvent($data);
    }

    public function deleteDate(ShippingEvent $shippingEvent, RapidCityTime $date)
    {
        if ($shippingEvent->isRecurring()) {
            $this->deleteDateInRecurringEvent->delete($shippingEvent, $date);
        } else {
            $this->deleteOneTimeEvent->delete($shippingEvent);
        }
    }

    private function deletedDateAdjustedEvent(array $data)
    {
        if ($data['date'] === $data['startDate']) {
            return;
        }
        $event = $this->findShippingEvent->find($data);
        $this->deleteDate($event, new RapidCityTime($data['startDate']));
    }

    private function doesEventFallOnDate(ShippingEvent $event, RapidCityTime $date): bool
    {
        if ($event->getRecurrenceType()->equals(RecurrenceType::MONTHLY())) {
            if ($event->getDayOfTheMonth() === $date->day) {
                return true;
            }

            return false;
        }
        if ($event->getRecurrenceType()->equals(RecurrenceType::WEEKLY())) {
            if ($event->getDayOfTheWeek()->getValue() === $date->dayOfWeek) {
                return true;
            }

            return false;
        }
        if ($event->getRecurrenceType()->equals(RecurrenceType::INTERMITTENT())) {
            if ($event->getNextWeekly()->dayOfWeek === $date->dayOfWeek) {
                return true;
            }

            return false;
        }
        if ($event->getRecurrenceType()->equals(RecurrenceType::FIRST_WEEKDAY_OF_MONTH())) {
            if ($event->getFirstWeekdayOfTheMonth()->getValue() !== $date->dayOfWeek) {
                return false;
            }

            return true;
        }
        if ($event->getRecurrenceType()->equals(RecurrenceType::LAST_WEEKDAY_OF_MONTH())) {
            if ($event->getLastWeekdayOfTheMonth()->getValue() !== $date->dayOfWeek) {
                return false;
            }

            return true;
        }
        if ($event->getRecurrenceType()->equals(RecurrenceType::DAILY())) {
            return true;
        }
        if ($event->getRecurrenceType()->equals(RecurrenceType::DOES_NOT_REPEAT())) {
            return $event->getStartDate()->eq($date);
        }
        $nextDate = $event->getStartDate()->clone();
        while ($nextDate->lt($date)) {
            if ($nextDate->eq($date)) {
                return true;
            }
            $nextDate = $this->getNextDate->get($event, $nextDate);
        }

        return false;
    }

    /**
     * @param $memberId
     * @param \Carbon\Carbon $date
     *
     * @return \AMB\Entity\Shipping\ShippingEvent[]
     * @throws \Exception
     */
    private function gatherEventsOnDate($memberId, RapidCityTime $date): array
    {
        $incomingEvents = $this->gatherShippingEventsInRange->gather($memberId, $date, $date);
        $events = [];
        foreach ($incomingEvents as $event) {
            if ($this->doesEventFallOnDate($event, $date)) {
                $events[] = $event;
            }
        }

        return $events;
    }
}
