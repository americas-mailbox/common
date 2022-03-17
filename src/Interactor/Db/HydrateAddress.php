<?php
declare(strict_types=1);

namespace AMB\Interactor\Db;

use AMB\Entity\Address;
use AMB\Entity\Membership;

final class HydrateAddress
{
    public function hydrate(array $addressData): Address
    {
        $postcodeParts = explode('-', $addressData['post_code']);
        if (count($postcodeParts) > 1) {
            $postcode = $postcodeParts[0];
            $plus4 = $postcodeParts[1];
        } else {
            $postcode = $addressData['post_code'];
            $plus4 = $addressData['plus4'];
        }
        $address = (new Address)
            ->setAddressee($addressData['addressee'])
            ->setCity($addressData['city'])
            ->setCountry($addressData['country'])
            ->setPlus4($plus4)
            ->setPostCode($postcode)
            ->setState($addressData['state'])
            ->setAddress($addressData['address'])
            ->setSuite($addressData['suite'])
            ->setLocationName($addressData['location_name'])
            ->setInCareOf($addressData['in_care_of'])
            ->setMembership((new Membership())->setId((int) $addressData['membership_id']));

        if (!empty($addressData['id'])) {
            $address->setId((int) $addressData['id']);
        }

        return $address;
    }
}
