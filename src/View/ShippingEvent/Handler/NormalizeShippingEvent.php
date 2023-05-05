<?php
declare(strict_types=1);

namespace AMB\View\ShippingEvent\Handler;

use AMB\Entity\Shipping\ShippingEvent;
use AMB\Interactor\RapidCityTime;
use Hashids\Hashids;

final class NormalizeShippingEvent
{
    public function __construct(
        private Hashids $hashids,
    ) {
    }

    public function normalize(ShippingEvent $shippingEvent): array
    {
        if ($address = $shippingEvent->getAddress()) {
            $addressId = $this->hashids->encode($address->getId());
            $addressData =
                [
                    'address'      => $address->getAddress(),
                    'addressee'    => $address->getAddressee(),
                    'city'         => $address->getCity(),
                    'country'      => $address->getCountry(),
                    'id'           => $addressId,
                    'inCareOf'     => $address->getInCareOf(),
                    'locationName' => $address->getLocationName(),
                    'plus4'        => $address->getPlus4(),
                    'postcode'     => $address->getPostcode(),
                    'state'        => $address->getState(),
                    'suite'        => $address->getSuite(),
                ];
        } else {
            $addressData = [];
            $addressId = null;
        }
        $deliveryMethod = $shippingEvent->getDeliveryMethod();
        $shippingEndDate = $shippingEvent->getEndDate();
        if ($shippingEndDate->gte(new RapidCityTime('2100-01-01'))) {
            $endDate = null;
            $recurrenceEnding = 'infinite';
        } else {
            $endDate = $shippingEndDate->toDateString();
            $recurrenceEnding = 'finite';
        }

        return [
            'address'          => $addressData,
            'addressId'        => $addressId,
            'id'               => $shippingEvent->getId(),
            'deliveryGroup'    => $deliveryMethod->getGroup(),
            'endDate'          => $endDate,
            'recurrence'       => null,
            'recurrenceEnding' => $recurrenceEnding,
            'deliveryMethod'   => [
                'id'         => $deliveryMethod->getId(),
                'label'      => $deliveryMethod->getDisplayedLabel(),
                'shortLabel' => $deliveryMethod->getShortLabel(),
            ],
            'deliveryMethodId' => $deliveryMethod->getId(),
            'memberId'         => $shippingEvent->getMember()->getId(),
            'startDate'        => null,
            'trackingNumber'   => null,
            'trackingUrl'      => null,
            'type'             => 'event',
            'wasPickedUp'      => false,
            'wasShipped'       => false,
            'weeksBetween'     => null,
        ];
    }
}
