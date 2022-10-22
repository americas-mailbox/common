<?php
declare(strict_types=1);

namespace AMB\Interactor\ShippingEvent;

use AMB\Entity\Shipping\ShippingEvent;
use AMB\Interactor\Shipping\GetPreviousDate;
use AMB\Interactor\Shipping\SaveShippingEvent;
use Carbon\Carbon;

final class DeleteThisAndFollowingEvent
{
    use DeletionHelper;

    public function __construct(
        private SaveShippingEvent $saveShippingEvent,
    ) {
    }

    public function delete(ShippingEvent $shippingEvent, Carbon $date): array
    {
        if ($date->eq($shippingEvent->getStartDate())) {
            $shippingEvent
                ->setActive(false)
                ->setNextWeekly(null);
            $this->saveShippingEvent->save($shippingEvent);

            return ['id' => $shippingEvent->getId()];
        }
        $deletedEvent = $this->clone($shippingEvent);
        $deletedEvent
            ->setActive(false)
            ->setNextWeekly(null)
            ->setStartDate($date);
        $this->saveShippingEvent->save($deletedEvent);

        $newEndDate = (new GetPreviousDate)($shippingEvent, $date);
        $shippingEvent
            ->setEndDate($newEndDate);
        $this->setNextWeekly($shippingEvent, $date);
        $this->saveShippingEvent->save($shippingEvent);

        return ['id' => $shippingEvent->getId()];
    }
}
