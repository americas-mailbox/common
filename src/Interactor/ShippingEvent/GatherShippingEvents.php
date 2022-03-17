<?php
declare(strict_types=1);

namespace AMB\Interactor\ShippingEvent;

use AMB\Interactor\Db\HydrateShippingEvent;
use Doctrine\DBAL\Connection;
use Exception;

abstract class GatherShippingEvents
{
    /** @var \Doctrine\DBAL\Connection */
    protected $connection;
    /** @var \AMB\Interactor\Db\HydrateShippingEvent */
    private $hydrateShippingEvent;

    public function __construct(
        Connection $connection,
        HydrateShippingEvent $hydrateShippingEvent
    ) {
        $this->connection = $connection;
        $this->hydrateShippingEvent = $hydrateShippingEvent;
    }

    /**
     * @return \AMB\Entity\Shipping\ShippingEvent[]
     * @throws \Doctrine\DBAL\DBALException
     */
    protected function handle(): array
    {
        $shippingEvents = [];
        $data = $this->fetchData();
        foreach ($data as $datum) {
            try {
                $shippingEvents[] = $this->hydrateShippingEvent->hydrate($datum);
            } catch (Exception $e) {
                // todo: logging
                $a = 0;
            }
        }

        return $shippingEvents;
    }

    protected function fetchData(): array
    {
        $statement = $this->connection->executeQuery($this->sql());

        return $statement->fetchAll();
    }

    abstract protected function sql(): string;
}
