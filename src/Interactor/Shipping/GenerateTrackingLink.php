<?php
declare(strict_types=1);

namespace AMB\Interactor\Shipping;

use AMB\Entity\Shipping\Delivery;

final class GenerateTrackingLink
{
    public function __invoke(Delivery $delivery): string
    {
        $carrier = $delivery->getCarrier()->getName();

        if ('FedEx' === $carrier) {
            return "https://www.fedex.com/apps/fedextrack/?tracknumbers=" . $delivery->getTrackingNumber();
        }

        if ('US Postal Service' === $carrier) {
            return "https://tools.usps.com/go/TrackConfirmAction?tLabels=" . $delivery->getTrackingNumber();
        }

        if ('UPS' === $carrier) {
            return "https://www.ups.com/track?loc=null&tracknum=" . $delivery->getTrackingNumber();
        }
    }
}
