<?php
declare(strict_types=1);

namespace AMB\Interactor\ShippingEvent;

use AMB\Entity\Shipping\ShippingEvent;
use AMB\Interactor\Shipping\GetNextDate;
use AMB\Interactor\Shipping\GetPreviousDate;
use AMB\Interactor\Shipping\Interfaces\SaveShippingEventInterface;
use Carbon\Carbon;

final class DeleteDateInRecurringEvent
{
    use DeletionHelper;

    public function __construct(
        private GetNextDate $getNextDate,
        private GetPreviousDate $getPreviousDate,
        private SaveShippingEventInterface $saveShippingEvent,
    ) { }

    public function delete(ShippingEvent $shippingEvent, Carbon $date)
    {
        if ($shippingEvent->getEndDate()->eq($date)) {
            $this->deleteEndDate($shippingEvent, $date);

            return;
        }
        if ($shippingEvent->getStartDate()->eq($date)) {
            $this->deleteStartDate($shippingEvent, $date);

            return;
        }
        $this->createNewEventAfterDate($shippingEvent, $date);
        $this->setEndOnPreviousDate($shippingEvent, $date);
        $this->createDeletionRecord($shippingEvent, $date);
    }

    private function createDeletionRecord(ShippingEvent $shippingEvent, Carbon $date)
    {
        $deletedEvent = $this->clone($shippingEvent);

        $deletedEvent
            ->setActive(false)
            ->setEndDate($date)
            ->setNextWeekly(null)
            ->setStartDate($date);

        $this->saveShippingEvent->save($deletedEvent);
    }

    private function createNewEventAfterDate(ShippingEvent $shippingEvent, Carbon $date)
    {
        $clone = $this->clone($shippingEvent);
        $nextDate = $this->getNextDate->get($shippingEvent, $date);
        $clone
            ->setStartDate($nextDate);
        $this->setNextWeekly($clone, $nextDate);
        $this->saveShippingEvent->save($clone);
    }

    private function deleteEndDate(ShippingEvent $shippingEvent, Carbon $date)
    {
        $previousDate = $this->getPreviousDate->get($shippingEvent, $date);
        $shippingEvent->setEndDate($previousDate);

        if ( $this->isIntermittent($shippingEvent) ) {
            if ($shippingEvent->getNextWeekly() && $shippingEvent->getNextWeekly()->eq($date)) {
                $shippingEvent
                    ->setActive(false)
                    ->setNextWeekly(null);
            }
        }
        $this->saveShippingEvent->save($shippingEvent);

        $this->createDeletionRecord($shippingEvent, $date);
    }

    private function deleteStartDate(ShippingEvent $shippingEvent, Carbon $date)
    {
        $nextDate = $this->getNextDate->get($shippingEvent, $date);
        $shippingEvent->setStartDate($nextDate);

        if ( $this->isIntermittent($shippingEvent) ) {
            $shippingEvent->setNextWeekly($nextDate);
        }
        $this->saveShippingEvent->save($shippingEvent);

        $this->createDeletionRecord($shippingEvent, $date);
    }

    private function setEndOnPreviousDate(ShippingEvent $shippingEvent, Carbon $date)
    {
        $previousDate = $this->getPreviousDate->get($shippingEvent, $date);
        $shippingEvent->setEndDate($previousDate);
        if ($previousDate->lt($shippingEvent->getNextWeekly())) {
            $shippingEvent
                ->setActive(false)
                ->setNextWeekly(null);
        }
        $this->saveShippingEvent->save($shippingEvent);
    }
}
