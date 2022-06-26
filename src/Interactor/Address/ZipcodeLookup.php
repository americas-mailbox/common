<?php
declare(strict_types=1);

namespace AMB\Interactor\Address;

use AMB\Entity\Address;
use USPS\Address as USPSAddress;
use USPS\ZipCodeLookup as Lookup;

final class ZipcodeLookup
{
    public function fromAddress(Address $address): array
    {
        return $this->lookup($address);
    }

    public function fromData(array $data)
    {
        $address = (new Address())
            ->setCity($data['city'])
            ->setCountry($data['country'])
            ->setState($data['state'])
            ->setAddress($data['address'])
            ->setSuite($data['suite']);

        return $this->lookup($address);
    }

    private function inLocationWithNoZipcode(Address $address): bool
    {
        $exemptCountries = [
            'AE',
            'AO',
            'AW',
            'BF',
            'BI',
            'BJ',
            'BM',
            'BO',
            'BQ',
            'BS',
            'BW',
            'CD',
            'CF',
            'CG',
            'CI',
            'CK',
            'CM',
            'CW',
            'DJ',
            'DM',
            'ER',
            'FJ',
            'GA',
            'GD',
            'GM',
            'GQ',
            'GY',
            'HK',
            'HM',
            'KI',
            'KP',
            'LY',
            'ML',
            'MO',
            'MR',
            'NR',
            'NU',
            'QA',
            'RW',
            'SB',
            'SC',
            'SL',
            'SR',
            'SS',
            'ST',
            'SX',
            'SY',
            'TD',
            'TF',
            'TG',
            'TL',
            'TK',
            'TO',
            'TV',
            'UG',
            'VU',
            'YE',
            'ZW',
        ];

        return in_array($address->getCountry(), $exemptCountries);
    }

    private function lookup(Address $address): array
    {
        $uspsAddress = (new USPSAddress())
            ->setAddress($address->getAddress())
            ->setCity($address->getCity())
            ->setState($address->getState());

        $lookup = $this->lookupAddress($uspsAddress);
        if ($lookup->isSuccess()) {
            return $this->returnResponse($lookup);
        }

        $uspsAddress->setAddress($address->getAddress());
        $lookup = $this->lookupAddress($uspsAddress);
        if ($lookup->isSuccess()) {
            return $this->returnResponse($lookup);
        }

        $streetAddress = trim($address->getAddress() . ' ' . $address->getSuite());
        $uspsAddress->setAddress($streetAddress);
        $lookup = $this->lookupAddress($uspsAddress);
        if ($lookup->isSuccess()) {
            return $this->returnResponse($lookup);
        }
        if ($this->inLocationWithNoZipcode($address)) {
            return [
                'success'   => true,
                'post_code' => ' ',
                'plus4'     => '',
            ];
        }

        return [
            'success' => false,
            'message' => 'The zipcode could not be found. Error: '. $lookup->getErrorMessage(),
        ];
    }

    private function lookupAddress(UspsAddress $uspsAddress): Lookup
    {
        $lookup = new Lookup(getenv('USPS_USERNAME'));
        $lookup->addAddress($uspsAddress);
        $lookup->lookup();

        return $lookup;
    }

    private function returnResponse(Lookup $lookup): array
    {
        $results = $lookup->getArrayResponse();
        $uspsAddress = $results['ZipCodeLookupResponse']['Address'];

        return [
            'success'   => true,
            'post_code' => $uspsAddress['Zip5'],
            'plus4'     => $uspsAddress['Zip4'],
        ];
    }
}
