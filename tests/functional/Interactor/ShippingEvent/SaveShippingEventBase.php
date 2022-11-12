<?php
declare(strict_types=1);

namespace ShippingEvent;

use AMB\Entity\Address;
use AMB\Entity\Member;
use AMB\Entity\Shipping\DeliveryMethod;
use AMB\Entity\Shipping\ShippingEvent;
use AMB\Interactor\ShippingEvent\SaveShippingEvent;
use Doctrine\DBAL\Connection;
use FunctionalTester;

abstract class SaveShippingEventBase
{
    /** @var \Psr\Container\ContainerInterface */
    protected $container;
    /** @var \AMB\Interactor\ShippingEvent\SaveShippingEvent */
    protected $saveShippingEvent;
    /** @var \Doctrine\DBAL\Connection */
    private $connection;

    public function _before(FunctionalTester $I)
    {
        $this->container = $I->getContainer();
        $this->connection = $this->container->get(Connection::class);
        $this->saveShippingEvent = $this->container->get(SaveShippingEvent::class);
    }

    protected function getCurrentEvent(array $data, $id): array
    {
        foreach ($data as $datum) {
            if ($datum['id'] == $id) {
                return $datum;
            }
        }
    }

    protected function getAddressData(): array
    {
        return [
        ];
    }

    protected function getShippingEvent(): ShippingEvent
    {
        $address = (new Address())
            ->setId(1);
        $deliveryMethod = (new DeliveryMethod())
            ->setId(5);
        $member = (new Member())
            ->setId(1);

        return (new ShippingEvent())
            ->setAddress($address)
            ->setDeliveryMethod($deliveryMethod)
            ->setMember($member);
    }

    protected function getShippingEventData(ShippingEvent $shippingEvent): array
    {
        $sql = <<<SQL
SELECT *
FROM shipping_events
WHERE id = {$shippingEvent->getId()}
SQL;

        return $this->connection->fetchAssociative($sql);
    }

    protected function getShippingEventDataForMember($memberId): array
    {
        $sql = <<<SQL
SELECT *
FROM shipping_events
WHERE member_id = $memberId
SQL;

        return $this->connection->fetchAllAssociative($sql);
    }

    protected function getUpdatedEvent(array $data, $id): array
    {
        foreach ($data as $datum) {
            if ($datum['id'] != $id) {
                return $datum;
            }
        }
    }

    protected function setupAddresses()
    {
        $this->connection->insert('addresses', $this->getAddressData());
    }
}
