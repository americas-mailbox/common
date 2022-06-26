<?php
declare(strict_types=1);

namespace AMB\Interactor\Address;

use AMB\Entity\Address\AddressVerification;
use Doctrine\DBAL\Connection;

final class UpdateAddressWithValidation
{
    public function __construct(
        private Connection $connection,
    ) {
    }

    public function update(AddressVerification $verification)
    {
        $resultData = $verification->getAddressData();
        $updateData = [
            'address' => $resultData['address'],
            'suite' => $resultData['suite'],
            'city' => $resultData['city'],
            'state' => $resultData['state'],
            'post_code' => $resultData['postcode'],
            'plus4' => $resultData['plus4'],
            'verified' => 1,
        ];
        if ($resultData['locationName']) {
            $updateData['location_name'] = $resultData['locationName'];
        }
        $this->connection->update('addresses', $updateData, ['id' => $verification->getAddressId()]);
    }
}
