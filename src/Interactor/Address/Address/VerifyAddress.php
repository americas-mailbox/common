<?php
declare(strict_types=1);

namespace AMB\Interactor\Address;

use AMB\Entity\Address;
use AMB\Entity\Address\AddressVerification;
use USPS\Address as UspsAddress;
use USPS\AddressVerify;

final class VerifyAddress
{
    public function verifyFromApi(array $data): array
    {
        $verification = $this->verifyFromApiData($data);

        return [
            'error'            => $verification->isError(),
            'errorMessage'     => $verification->getErrorMessage(),
            'rawData'          => $verification->getRawData(),
            'suggestedAddress' => $verification->getAddressData(),
            'warningMessage'   => $verification->getWarningMessage(),
        ];
    }

    public function verifyFromApiData(array $data): AddressVerification
    {
        // order matters
        $uspsAddress = (new UspsAddress())
            ->setFirmName($data['locationName'] ?? '')
            ->setApt($data['suite'] ?? '')
            ->setAddress($data['address'])
            ->setCity($data['city'])
            ->setState($data['state']);

        if ($data['country'] === 'US') {
            if (empty($data['plus4'])) {
                $parts = explode('-', $data['postcode']);
                if (isset($parts[1])) {
                    $data['postcode'] = $parts[0];
                    $data['plus4'] = $parts[1];
                }
            } else {
                $data['plus4'] = '';
            }

            $uspsAddress
                ->setZip5($data['postcode'])
                ->setZip4($data['plus4']);
        } else {
            $a = $data['country'];
        }

        return $this->verifyAddress($uspsAddress, $data['id']);
    }

    public function verify(Address $address): AddressVerification
    {
        // order matters
        $uspsAddress = (new UspsAddress())
            ->setFirmName($address->getLocationName())
            ->setApt($address->getSuite())
            ->setAddress($address->getAddress())
            ->setCity($address->getCity())
            ->setState($address->getState())
            ->setZip5($address->getPostCode())
            ->setZip4($address->getPlus4());

        return $this->verifyAddress($uspsAddress, $address->getId());
    }

    private function determineMatch($data): bool
    {
        if (!isset($data['AddressValidateResponse']['Address'])) {
            return false;
        }
        if (isset($data['AddressValidateResponse']['Address']['ReturnText'])) {
            return false;
        }
        if (isset($data['AddressValidateResponse']['Address']['Error'])) {
            return false;
        }

        return true;
    }

    private function getAddressDataFromResponse(array $data): array
    {
        if (!isset($data['AddressValidateResponse']['Address'])) {
            return [];
        }
        $responseAddress = $data['AddressValidateResponse']['Address'];

        return [
            'locationName' => $responseAddress['FirmName'] ?? '',
            'address'      => $responseAddress['Address2'] ?? '',
            'suite'        => $responseAddress['Address1'] ?? '',
            'city'         => $responseAddress['City'] ?? '',
            'state'        => $responseAddress['State'] ?? '',
            'postcode'     => $responseAddress['Zip5'] ?? '',
            'plus4'        => $responseAddress['Zip4'] ?? '',
        ];
    }

    private function getErrorMessageFromResponse(array $data): string
    {
        if (!isset($data['AddressValidateResponse']['Address'])) {
            return '';
        }

        $message = $data['AddressValidateResponse']['Address']['Error']['Description'];
        if ($message === "Address Not Found.") {
            return "We couldn't find the address.";
        }

        return '';
    }

    private function verifyAddress(UspsAddress $address, $addressId): AddressVerification
    {
        $verify = new AddressVerify(getenv('USPS_USERNAME'));
        $verify->addAddress($address);
        $verify->verify();
        $response = $verify->getArrayResponse();
        $addressData = $this->getAddressDataFromResponse($response);

        return (new AddressVerification())
            ->setAddressData($addressData)
            ->setAddressId($addressId)
            ->setError($verify->isError())
            ->setErrorMessage($this->getErrorMessageFromResponse($response))
            ->setMatch($this->determineMatch($response))
            ->setRawData($response)
            ->setWarningMessage($responseAddress['ReturnText'] ?? '');
    }
}
