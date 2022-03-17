<?php
declare(strict_types=1);

namespace AMB\Interactor\Db;

use AMB\Entity\Member;
use AMB\Entity\Shipping\DayOfTheWeek;
use AMB\Entity\Shipping\RecurrenceType;
use AMB\Entity\Shipping\ShippingEvent;
use AMB\Interactor\RapidCityTime;

final class HydrateShippingEvent
{
    public function __construct(
        private HydrateDeliveryMethod $hydrateDeliveryMethod,
        private HydrateAddress $hydrateAddress,
    ) {}

    public function __invoke(array $data): ShippingEvent
    {
        return $this->hydrate($data);
    }

    public function hydrate(array $data): ShippingEvent
    {
        $deliveryCarrier = [];
        if (isset($data['deliveryCarrierName'])) {
            $deliveryCarrier = [
                'active' => $data['deliveryCarrierActive'],
                'id' => $data['deliveryCarrierId'],
                'name' => $data['deliveryCarrierName'],
            ];
        }
        $deliveryMethodData = [
            'delivery_carrier' => $deliveryCarrier,
            'group' => $data['deliveryMethodGroup'],
            'id' => $data['deliveryMethodId'],
            'label' => $data['deliveryMethodLabel'],
        ];

        $deliveryMethod= $this->hydrateDeliveryMethod->hydrate($deliveryMethodData);

        $nextWeekly = !empty($data['next_weekly']) ? new RapidCityTime($data['next_weekly']) : null;
        $weeksBetween = !empty($data['weeks_between']) ? (int) $data['weeks_between'] : null;
        $member = (new Member())
            ->setId((int) $data['member_id']);

        $shippingEvent = (new ShippingEvent())
            ->setActive((bool)(int) $data['is_active'])
            ->setDaily((bool)(int) $data['daily'])
            ->setDayOfTheMonth((int)$data['day_of_the_month'])
            ->setDayOfTheWeek($this->hydrateDayOfTheWeek($data['day_of_the_week']))
            ->setDeliveryMethod($deliveryMethod)
            ->setEndDate(new RapidCityTime($data['end_date']))
            ->setFirstWeekdayOfTheMonth($this->hydrateDayOfTheWeek((int)$data['first_weekday_of_the_month']))
            ->setId((int) $data['id'])
            ->setLastWeekdayOfTheMonth($this->hydrateDayOfTheWeek((int)$data['last_weekday_of_the_month']))
            ->setMember($member)
            ->setNextWeekly($nextWeekly)
            ->setRecurrenceType(new RecurrenceType($data['recurrence_type']))
            ->setStartDate(new RapidCityTime($data['start_date']))
            ->setWeeksBetween($weeksBetween);

        if (!empty($data['addressId'])) {
            $addressData = [
                'addressee'     => $data['addressee'],
                'city'          => $data['city'],
                'country'       => $data['country'],
                'id'            => (int)$data['addressId'],
                'plus4'         => $data['plus4'],
                'post_code'     => $data['postcode'],
                'state'         => $data['state'],
                'address'       => $data['address'],
                'suite'         => $data['suite'],
                'location_name' => $data['locationName'],
                'in_care_of'    => $data['inCareOf'],
                'membership_id' => $data['member_id'],
            ];
            $address = $this->hydrateAddress->hydrate($addressData);
            $shippingEvent->setAddress($address);
        }

        return $shippingEvent;
    }

    public function hydrateDayOfTheWeek($day): ?DayOfTheWeek
    {
        $day = (int) $day;
        if (0 === $day) {
            return null;
        }

        return new DayOfTheWeek($day);
    }
}
