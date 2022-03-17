<?php
declare(strict_types=1);

namespace AMB\View\ShippingEvent\Handler;

use AMB\Entity\Shipping\ShippingEvent;
use AMB\Interactor\RapidCityTime;

interface RecurrenceHandlerInterface
{
    public function handle(ShippingEvent $shippingEvent, RapidCityTime $startDate, RapidCityTime $endDate): array;
}
