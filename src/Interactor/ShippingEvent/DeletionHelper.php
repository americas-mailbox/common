<?php
declare(strict_types=1);

namespace AMB\Interactor\ShippingEvent;

use AMB\Entity\Shipping\RecurrenceType;
use AMB\Entity\Shipping\ShippingEvent;
use AMB\Interactor\Db\ClearId;
use Carbon\Carbon;
use function DeepCopy\deep_copy;

trait DeletionHelper
{
    protected function clone(ShippingEvent $shippingEvent): ShippingEvent
    {
        $clone = deep_copy($shippingEvent);

        (new ClearId)($clone);

        return $clone;
    }

    protected function isIntermittent(ShippingEvent $shippingEvent): bool
    {
        $recurrenceType = $shippingEvent->getRecurrenceType();

        return (
            $recurrenceType->equals(RecurrenceType::INTERMITTENT()) ||
            $recurrenceType->equals(RecurrenceType::WEEKLY())
        );
    }

    /**
     * @param \AMB\Entity\Shipping\ShippingEvent $event
     * @param \Carbon\Carbon $date
     *
     * Always call this AFTER event manipulation
     */
    protected function setNextWeekly(ShippingEvent $event, Carbon $date)
    {
        if (!$this->isIntermittent($event)) {
            $event->setNextWeekly(null);

            return;
        }
        if (!$currentNextWeekly = $event->getNextWeekly()) {
            return;
        }

        $startDate = $event->getStartDate();
        if ($currentNextWeekly->lt($startDate)) {
            $event->setNextWeekly($startDate);

            return;
        }

        $endDate = $event->getEndDate();
        if ($currentNextWeekly->gt($endDate)) {
            $event->setNextWeekly(null);

            return;
        }
    }
}
