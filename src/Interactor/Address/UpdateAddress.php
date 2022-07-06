<?php
declare(strict_types=1);

namespace AMB\Interactor\Address;

use AMB\Entity\Address;
use AMB\Interactor\Db\BoolToSQL;
use Doctrine\DBAL\Connection;

final class UpdateAddress
{
    public function __construct(
        private Connection $connection,
        private SetAddressAsDefault $setAddressAsDefault,
    ) {
    }

    public function updateFromApi(array $data): bool
    {
        if (isset($data['inCareOf'])) {
            $data['in_care_of'] = $data['inCareOf'];
            unset($data['inCareOf']);
        }
        if (isset($data['locationName'])) {
            $data['location_name'] = $data['locationName'];
            unset($data['locationName']);
        }
        if (isset($data['postcode'])) {
            $data['post_code'] = $data['postcode'];
            unset($data['postcode']);
        }
        if (isset($data['isVerified'])) {
            $data['verified'] = (new BoolToSQL)($data['isVerified']);
            unset($data['isVerified']);
        }

        return $this->persist($data['id'], $data);
    }

    public function update(Address $address)
    {
        $data = [
            'addressee'     => $address->getAddressee(),
            'address'       => $address->getAddress(),
            'suite'         => $address->getSuite(),
            'location_name' => $address->getLocationName(),
            'city'          => $address->getCity(),
            'state'         => $address->getState(),
            'country'       => $address->getCountry(),
            'post_code'     => $address->getPostCode(),
        ];
        $this->persist($address->getId(), $data);

        return (int)$address->getId();
    }

    private function persist($id, array $data)
    {
        if (isset($data['setAsDefaultAddress']) && true === $data['setAsDefaultAddress']) {
            $this->setAddressAsDefault->setAddress($id, $data['memberId']);
            unset($data['setAsDefaultAddress']);
        }
        unset($data['memberId']);
        $response = $this->connection->update('addresses', $data, ['id' => $id]);
        if (1 !== $response) {
            return false;
        }

        return true;
    }

    public function hideUnhide(Address $address)
    {
        $data = [
            'deleted' => $address->getDeleted(),
        ];
        $response = $this->connection->update('addresses', $data, ['id' => $address->getId()]);
        if (1 !== $response) {
            return;
        }

        return (int)$address->getId();
    }
}
