<?php
declare(strict_types=1);

namespace AMB\Interactor\Address;

use AMB\Entity\Address;
use AMB\Interactor\Db\BoolToSQL;
use Doctrine\DBAL\Connection;

final class InsertAddress
{
    public function __construct(
        private Connection $connection,
    ) {}

    public function insert(Address $address)
    {
        $data = [
            'addressee'     => $address->getAddressee(),
            'address'       => $address->getAddress(),
            'city'          => $address->getCity(),
            'country'       => $address->getCountry(),
            'in_care_of'    => $address->getInCareOf(),
            'location_name' => $address->getLocationName(),
            'membership_id' => $address->getMembership()->getId(),
            'post_code'     => $address->getPostCode(),
            'state'         => $address->getState(),
            'suite'         => $address->getSuite(),
            'verified'      => (new BoolToSQL)($address->isVerified()),
        ];

        $response = $this->connection->insert('addresses', $data);
        if (1 !== $response) {
            return;
        }
        $id = (int) $this->connection->lastInsertId();
        $address->setId($id);
    }
}
