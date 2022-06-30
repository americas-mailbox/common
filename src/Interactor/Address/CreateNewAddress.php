<?php
declare(strict_types=1);

namespace AMB\Interactor\Address;

use AMB\Entity\Address;
use AMB\Entity\Membership;
use AMB\Interactor\Member\FindMemberById;
use Doctrine\DBAL\Connection;

final class CreateNewAddress
{
    public function __construct(
        private Connection $connection,
        private FindMemberById $findMemberById,
        private InsertAddress $insertAddress,
    ) { }

    public function createFromApi(array $data): array
    {
        $address = (new Address())
            ->setAddressee($data['addressee'] ?? '')
            ->setAddress($data['address'])
            ->setCity($data['city'])
            ->setCountry($data['country'])
            ->setInCareOf($data['inCareOf'] ?? '')
            ->setLocationName($data['locationName'] ?? '')
            ->setMembership((new Membership())->setId((int)$data['memberId']))
            ->setPlus4($data['plus4'] ?? '')
            ->setPostCode($data['postcode'] ?? '')
            ->setState($data['state'] ?? '')
            ->setSuite($data['suite'] ?? '')
            ->setVerified($data['isVerified'] ?? false);

        $this->insertAddress->insert($address);

        if (isset($data['setAsDefaultAddress']) && true === $data['setAsDefaultAddress']) {
            $member = $this->findMemberById->find($data['memberId']);
            $this->connection->update(
                'accounts',
                [
                    'default_address_id' => $address->getId(),
                ],
                [
                    'id' => $member->getAccount()->getId(),
                ]
            );
        }

        return ['id' => $address->getId()];
    }
}
