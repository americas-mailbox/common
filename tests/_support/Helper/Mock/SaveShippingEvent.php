<?php
declare(strict_types=1);

namespace Helper\Mock;

use AMB\Entity\Shipping\ShippingEvent;
use AMB\Interfaces\ShippingEvent\SaveShippingEventInterface;
use ReflectionProperty;

final class SaveShippingEvent implements SaveShippingEventInterface
{
    /** @var int */
    private $nextId = 1;
    /** @var ShippingEvent[] */
    private $savedEvents = [];

    public function getEvents(): array
    {
        return $this->savedEvents;
    }

    public function getSortedEvents(): array
    {
        $sort = function($a, $b) {
            return $a->getStartDate()->gt($b->getStartDate()) ? 1 : -1;
        };
        $events = $this->savedEvents;
        uasort($events, $sort);

        return array_values($events);
    }

    public function reset()
    {
        $this->nextId = 1;
        $this->savedEvents = [];
    }

    public function save(ShippingEvent $shippingEvent)
    {
        $idProperty = new ReflectionProperty($shippingEvent, 'id');
        $idProperty->setAccessible(true);
        $id = $idProperty->getValue($shippingEvent);
        if (null === $id) {
            $shippingEvent->setId($this->nextId);

            $this->nextId++;
        }
        $this->savedEvents[$shippingEvent->getId()] = $shippingEvent;
    }
}
