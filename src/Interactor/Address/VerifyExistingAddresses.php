<?php
declare(strict_types=1);

namespace AMB\Interactor\Address;

use AMB\Interactor\UpdateManager;
use Doctrine\DBAL\Connection;

final class VerifyExistingAddresses
{
    private const KEY_NAME = 'addressVerificationAddressId';

    public function __construct(
        private Connection $connection,
        private UpdateAddressWithValidation $updateAddress,
        private UpdateManager $updateManager,
        private VerifyAddress $verifyAddress,
    ) {
    }

    public function verify()
    {
        $this->verifyAddresses();

    }

    private function getAddressesForMembership($membershipId): array
    {
        $sql = <<<SQL
SELECT 
    id,
    street_1 as address,
    street_2 as suite,
       city,
       state,
       country,
       post_code AS postcode,
       plus4
FROM addresses
WHERE membership_id = $membershipId
AND verified = 0
AND deleted = 0
SQL;

        return $this->connection->fetchAllAssociative($sql);
    }


    private function getAddresses($addressId): array
    {
        $sql = <<<SQL
SELECT 
    id,
    street_3 as address,
       city,
       state,
       country,
       post_code AS postcode,
       plus4
FROM addresses
WHERE verified = 0
AND deleted = 0
AND id > $addressId
SQL;

        return $this->connection->fetchAllAssociative($sql);
    }

    private function getMembershipIds(): array
    {
        $nextMembershipId = $this->updateManager->get(self::KEY_NAME);
        $nextMembershipId = $nextMembershipId ?? 120000;
        $sql = <<<SQL
SELECT member_id
FROM members
WHERE member_id <= $nextMembershipId
ORDER BY member_id DESC
SQL;

        return $this->connection->fetchFirstColumn($sql);
    }

    private function verifyAddressData(array $address)
    {
        $validation = $this->verifyAddress->verifyFromApiData($address);
        if (!$validation->isMatch()) {
            return;
        }
        $this->updateAddress->update($validation);
    }

    private function verifyAddresses()
    {
        $addressId = (int) $this->updateManager->get(self::KEY_NAME);

        $addresses = $this->getAddresses($addressId);
        foreach ($addresses as $address) {
            $addressId = (int) $address['id'];
            $this->verifyAddressData($address);
            $this->updateManager->set(self::KEY_NAME, $addressId + 1);
        }

        $this->updateManager->drop(self::KEY_NAME);
    }

    private function verifyAddressesForMembership(int $membershipId)
    {
        $addresses = $this->getAddressesForMembership($membershipId);
        foreach ($addresses as $address) {
            $this->verifyAddressData($address);
        }
    }
}
