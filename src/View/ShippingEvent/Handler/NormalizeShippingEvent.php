<?php
declare(strict_types=1);

namespace AMB\View\ShippingEvent\Handler;

use AMB\Entity\Shipping\ShippingEvent;
use AMB\Interactor\RapidCityTime;

final class NormalizeShippingEvent
{
    public function normalize(ShippingEvent $shippingEvent): array
    {
        if ($address = $shippingEvent->getAddress()) {
            $addressData =
                [
                    'address'      => $address->getAddress(),
                    'addressee'    => $address->getAddressee(),
                    'city'         => $address->getCity(),
                    'country'      => $address->getCountry(),
                    'id'           => $address->getId(),
                    'inCareOf'     => $address->getInCareOf(),
                    'locationName' => $address->getLocationName(),
                    'plus4'        => $address->getPlus4(),
                    'postcode'     => $address->getPostcode(),
                    'state'        => $address->getState(),
                    'suite'        => $address->getSuite(),
                ];
            $addressId = $address->getId();
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
