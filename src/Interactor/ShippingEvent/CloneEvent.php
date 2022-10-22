<?php
declare(strict_types=1);

namespace AMB\Interactor\ShippingEvent;

use AMB\Entity\Shipping\ShippingEvent;
use AMB\Interactor\Db\ClearId;
use AMB\Interactor\RapidCityTime;
use AMB\Interactor\Shipping\GetPreviousDate;
use DeepCopy\DeepCopy;

final class CloneEvent
{
    public function clone(ShippingEvent $shippingEvent): ShippingEvent
    {
        /** @var \AMB\Entity\Shipping\ShippingEvent $clone */
        $clone = (new DeepCopy())->copy($shippingEvent);
        (new ClearId)($clone);

        return $clone;
    }

    public function split(ShippingEvent $shippingEvent, RapidCityTime $date): ShippingEvent
    {
        $clone = $this->clone($shippingEvent);
        $previousDate = (new GetPreviousDate)($shippingEvent, $date);
        $clone->setStartDate($date->clone());
        $shippingEvent->setEndDate($previousDate);

        return $clone;
    }
}
