<?php
declare(strict_types=1);

namespace AMB\Interactor\Address;

use AMB\Interactor\Member\FindMemberById;
use Doctrine\DBAL\Connection;

final class SetAddressAsDefault
{
    public function __construct(
        private Connection $connection,
        private FindMemberById $findMemberById,
    ) {}

    public function setAddress($addressId, $memberId)
    {
        $member = $this->findMemberById->find($memberId);
        $this->connection->update(
            'accounts',
            [
                'default_address_id' => $addressId,
            ],
            [
                'id' => $member->getAccount()->getId(),
            ]
        );
    }
}
