<?php
declare(strict_types=1);

namespace AMB\Factory\ShippingEvents;

use AMB\Interactor\ShippingEvent\EventChangeManager;
use AMB\Interfaces\ShippingEvent\SaveShippingEventInterface;
use Psr\Container\ContainerInterface;

final class EventChangeManagerFactory
{
    public function __invoke(ContainerInterface $container): EventChangeManager
    {
        $saveShippingEvent = $container->get(SaveShippingEventInterface::class);

        return new EventChangeManager($saveShippingEvent);
    }
}
