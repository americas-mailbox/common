<?php
declare(strict_types=1);

namespace AMB\Factory\ShippingEvent;

use AMB\Entity\Address;
use AMB\Entity\Member;
use AMB\Entity\Shipping\DeliveryMethod;
use AMB\Entity\Shipping\ShippingEvent;
use AMB\Interactor\RapidCityTime;
use AMB\Interactor\Shipping\CreateShipment;
use AMB\Interfaces\ShippingEvent\SaveShippingEventInterface;
use Doctrine\DBAL\Connection;

final class ShippingEventFactory
{
    public function __construct(
        private Connection $connection,
        private CreateShipment $createShipment,
        private SaveShippingEventInterface $insertShippingEvent,
    ) { }

    public function createFromApi(array $data, $adminId, $memberId): array
    {
        if ('doesNotRepeat' === $data['recurrence']) {
            $factory = OneTimeShippingEventFactory::class;
        } else {
            $factory = 'AMB\\Factory\\ShippingEvent\\' . ucfirst($data['recurrence']) . 'RecurrenceShippingEventFactory';
        }

        /** @var ShippingEvent $shippingEvent */
        $shippingEvent = (new $factory)($data);

        $this->setAddress($shippingEvent, $data);
        $this->setDeliveryMethod($shippingEvent, $data);
        $this->setMember($shippingEvent, $data);

        $this->insertShippingEvent->save($shippingEvent);

        // if admin and it's today, then create a new shipment
        $today = RapidCityTime::today();
        $role = $data['role'] ?? '';
        if ('admin' === $role && (new RapidCityTime($data['startDate']))->equalTo($today)) {
            $this->createShipment->create(
                $shippingEvent->getMember(),
                $shippingEvent->getAddress(),
                $shippingEvent->getDeliveryMethod(),
                $today
            );
        }
        $eventId = ['id' => $shippingEvent->getId()];
        $data = [
            'created_by_admin_id'  => $adminId,
            'created_by_member_id' => $memberId,
        ];
        $this->connection->update('shipping_events', $data, $eventId);

        return $eventId;
    }

    private function setAddress(ShippingEvent $shippingEvent, array $data)
    {
        if ('pickup' === $data['deliveryGroup']) {
            $data['addressId'] = 1;
        }
        if (empty($data['addressId'])) {
            return;
        }
        $address = (new Address())
            ->setId((int) $data['addressId']);

        $shippingEvent->setAddress($address);
    }

    private function setDeliveryMethod(ShippingEvent $shippingEvent, array $data)
    {
        $deliveryMethodId = 'pickup' === $data['deliveryGroup'] ? 7 : $data['deliveryMethodId'];
        $deliveryMethodId = empty($deliveryMethodId) ? 5 : $deliveryMethodId; // if we end up with a non-value

        $deliveryMethod = (new DeliveryMethod())
            ->setId((int) $deliveryMethodId);

        $shippingEvent->setDeliveryMethod($deliveryMethod);
    }

    private function setMember(ShippingEvent $shippingEvent, array $data)
    {
        $member = (new Member())
            ->setId((int) $data['memberId']);

        $shippingEvent->setMember($member);
    }
}
