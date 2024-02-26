<?php
declare(strict_types=1);

namespace AMB\Interface\ShippingEvent;

use AMB\Entity\Shipping\ShippingEvent;

interface SaveShippingEventInterface
{
    public function save(ShippingEvent $calendarEvent);
}
