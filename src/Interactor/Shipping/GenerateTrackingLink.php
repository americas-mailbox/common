<?php
declare(strict_types=1);

namespace AMB\Interactor\Shipping;

use AMB\Entity\Shipping\Delivery;

final class GenerateTrackingLink
{
    public function __invoke(Delivery $delivery): string
    {
        $carrier = $delivery->getCarrier()->getName();
        $trackingNumber = $delivery->getTrackingNumber();
        return $this->generate($carrier, $trackingNumber);
    }

    public function generate(string $carrier, string $trackingNumber): string
    {
        if ('FedEx' === $carrier) {
            return "https://www.fedex.com/apps/fedextrack/?tracknumbers=$trackingNumber";
        }

        if ('US Postal Service' === $carrier) {
            return "https://tools.usps.com/go/TrackConfirmAction?tLabels=$trackingNumber";
        }

        if ('UPS' === $carrier) {
            return "https://www.ups.com/track?loc=null&tracknum=$trackingNumber";
        }
    }
}
