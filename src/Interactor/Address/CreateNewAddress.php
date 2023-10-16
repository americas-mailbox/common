<?php
declare(strict_types=1);

namespace AMB\Interactor\Address;

use AMB\Entity\Address;
use Application\Interactor\Hasher;
use Domain\Membership\Entity\Membership;

final class CreateNewAddress
{
    public function __construct(
        private Hasher $hasher,
        private InsertAddress $insertAddress,
        private SetAddressAsDefault $setAddressAsDefault,
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
            ->setMembership((new Membership())->setId($this->hasher->encode($data['memberId'])))
            ->setPlus4($data['plus4'] ?? '')
            ->setPostCode($data['postcode'] ?? '')
            ->setState($data['state'] ?? '')
            ->setSuite($data['suite'] ?? '')
            ->setVerified($data['isVerified'] ?? false);

        $this->insertAddress->insert($address);

        if (isset($data['isDefault'])) {
            $data['setAsDefaultAddress'] = $data['isDefault'];
        }
        if (isset($data['setAsDefaultAddress']) && true === $data['setAsDefaultAddress']) {
            $this->setAddressAsDefault->setAddress($address->getId(), $data['memberId']);
        }

        return ['id' => $address->getId()];
    }
}
