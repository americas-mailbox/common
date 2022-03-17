<?php
declare(strict_types=1);

namespace AMB\View\ShippingEvent;

use AMB\Entity\Shipping\Carrier;
use AMB\Entity\Shipping\Delivery;
use AMB\Interactor\RapidCityTime;
use AMB\Interactor\Shipping\GenerateTrackingLink;
use AMB\View\FormatDate;
use Doctrine\DBAL\Connection;

final class GatherPastShipments
{
    /** @var \AMB\View\FormatDate */
    private $formatDate;

    public function __construct(
        private Connection $connection,
    ) {
        $this->formatDate = new FormatDate();
    }

    public function gather($memberId, RapidCityTime $startDate, RapidCityTime $endDate): array
    {
        $sql = $this->pastShipmentsSQL($memberId, $startDate, $endDate);
        $data = $this->connection->fetchAllAssociative($sql);
        if (empty($data)) {
            return [];
        }
        $events = [];
        foreach ($data as $datum) {
            $events[] = $this->normalizePastShipmentData($datum);
        }

        return $events;
    }

    private function getMethodLabel(array $data): string
    {
        $label = '';
        if ($data['service_code']) {
            $services = [
                'fedex_two_day'                  => 'FedEx 2nd Day',
                'fedex_two_day_am'               => 'FedEx 2nd Day AM',
                'fedex_express_saver'            => 'FedEx Express Saver',
                'fedex_ground'                   => 'FedEx Ground',
                'fedex_ground_canada'            => 'FedEx Ground Canada',
                'fedex_first_overnight'          => 'FedEx Overnight',
                'fedex_ground_home_delivery'     => 'FedEx Ground Home Delivery',
                'fedex_international_economy'    => 'FedEx International',
                'fedex_international_priority'   => 'FedEx International Priority',
                'fedex_priority_overnight'       => 'FedEx Priority Overnight',
                'fedex_standard_overnight'       => 'FedEx Standard Overnight',
                'FEDEX_2_DAY'                    => 'FedEx 2nd Day',
                'FEDEX_2_DAY_AM'                 => 'FedEx 2nd Day AM',
                'FEDEX_EXPRESS_SAVER'            => 'FedEx Express Saver',
                'FEDEX_GROUND'                   => 'FedEx Ground',
                'FEDEX_GROUND_CANADA'            => 'FedEx Ground Canada',
                'FIRST_OVERNIGHT'                => 'FedEx Overnight',
                'GROUND_HOME_DELIVERY'           => 'FedEx Ground Home Delivery',
                'INTERNATIONAL_ECONOMY'          => 'FedEx International',
                'INTERNATIONAL_PRIORITY'         => 'FedEx International Priority',
                'PRIORITY_OVERNIGHT'             => 'FedEx Priority Overnight',
                'STANDARD_OVERNIGHT'             => 'FedEx Standard Overnight',
                'ups_ground'                     => 'UPS Ground',
                'ups_next_day_air'               => 'UPS Next Day Air',
                'ups_next_day_air_saver'         => 'UPS Next Day Air Saver',
                'ups_second_day_air'             => 'UPS 2nd Day Air',
                'ups_standard'                   => 'UPS Standard',
                'ups_three_day_select'           => 'UPS 3 Day Select',
                'US-FC'                          => 'USPS First Class',
                'US-PM'                          => 'USPS Priority Mail',
                'US-XM'                          => 'USPS 2nd Day',
                'US-EMI'                         => 'USPS International',
                'US-FCI'                         => 'USPS International',
                'US-PMI'                         => 'USPS International',
                'usps_express'                   => 'USPS 2nd Day',
                'usps_first_class'               => 'USPS First Class',
                'usps_priority'                  => 'USPS Priority Mail',
                'usps_international_express'     => 'USPS International',
                'usps_international_first_class' => 'USPS International',
                'usps_international_priority'    => 'USPS International',
            ];

            if (isset($services[$data['service_code']])) {
                return $services[$data['service_code']];
            }
        }

        if (!empty($data['shipping_carrier_name'])) {
            $label .= $data['shipping_carrier_name'] . ' - ';
        }

        $label .= $data['shipping_method_label'];

        return $label;
    }

    private function getPostCode(array $data): string
    {
        $postcode = $data['postcode'];
        if (!empty($data['plus4'])) {
            $postcode .= '-' . $data['plus4'];
        }

        return (string) $postcode;
    }

    private function normalizePastShipmentData($data): array
    {
        $shippingMethodLabel = $this->getMethodLabel($data);
        $postcode = $this->getPostCode($data);

        if ($data['tracking_number'] && $data['shipping_carrier_name']) {
            $carrier = (new Carrier())
                ->setName($data['shipping_carrier_name']);
            $delivery = (new Delivery())
                ->setCarrier($carrier)
                ->setTrackingNumber($data['tracking_number']);
            $trackingUrl = (new GenerateTrackingLink())($delivery);
        } else {
            $trackingUrl = null;
        }

        $pending = $data['fulfilled'] !== 0 && $data['date'] === (RapidCityTime::today())->toDateString();

        return [
            'address'             => [
                'addressee'    => $data['addressee'],
                'city'         => $data['city'],
                'country'      => $data['country'],
                'id'           => (int)$data['addressId'],
                'postcode'     => $postcode,
                'state'        => $data['state'],
                'address'      => $data['address'],
                'suite'        => $data['suite'] ?? '',
                'inCareOf'     => $data['inCareOf'] ?? '',
                'locationName' => $data['locationName'] ?? '',
            ],
            'addressId'           => (int)$data['addressId'],
            'date'                => $this->formatDate->__invoke($data['date']),
            'deliveryGroup'       => $data['shipping_method_group'],
            'endDate'             => $this->formatDate->__invoke($data['date']),
            'id'                  => (int)$data['id'],
            'inThePast'           => true,
            'recurrence'          => null,
            'recurrenceEnding'    => null,
            'deliveryMethod'      => [
                'id'         => (int)$data['delivery_method_id'],
                'label'      => $shippingMethodLabel,
                'isPending'  => $pending,
                'shortLabel' => $data['shipping_internal_short_label'],
            ],
            'deliveryMethodId'    => (int)$data['delivery_method_id'],
            'startDate'           => $this->formatDate->__invoke($data['date']),
            'trackingNumber'      => $data['tracking_number'],
            'trackingUrl'         => $trackingUrl,
            'type'                => 'shipment',
            'wasPickedUp'         => false,
            'wasShipped'          => (bool)$data['fulfilled'],
            'weeksBetween'        => null,
        ];
    }

    private function pastShipmentsSQL($memberId, RapidCityTime $startDate, RapidCityTime $endDate): string
    {
        return <<<SQL
SELECT 
    s.*,
    a.addressee,
    a.id as addressId,
    a.address,       
    a.suite,       
    a.location_name AS locationName, 
    a.in_care_of AS inCareOf, 
    a.city,
    a.country,
    a.state,
    a.post_code AS postcode,      
    a.plus4,
    dm.label AS shipping_method_label,
    dm.group AS shipping_method_group,
    dm.internal_short_label AS shipping_internal_short_label,
    dc.name AS shipping_carrier_name,
    d.service_code,
    d.tracking_number
FROM shipments AS s
LEFT JOIN addresses AS a ON s.address_id = a.id
LEFT JOIN deliveries AS d ON s.delivery_id = d.id
LEFT JOIN delivery_methods AS dm ON s.delivery_method_id = dm.id
LEFT JOIN delivery_carriers AS dc ON d.carrier_id = dc.id
WHERE member_id = $memberId
AND date >= '{$startDate->toDateString()}'
AND date <= '{$endDate->toDateString()}'
SQL;
    }
}
