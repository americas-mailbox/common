<?php
declare(strict_types=1);

namespace AMB\Interactor\Parcel;

use AMB\Entity\Member;
use AMB\Interactor\RapidCityTime;
use Doctrine\DBAL\Connection;
use IamPersistent\Ledger\Entity\Entry;
use OLPS\SimpleShop\Entity\Product;
use Zestic\Contracts\User\UserInterface;

final class AddPkgSkuToTransactionTable
{
    public function __construct(
        private Connection $connection,
    ) {
    }

    public function add(Member $member, Entry $entry, Product $sku, ?UserInterface $actor)
    {
        $data = [
            'admin_id'   => $actor->getId(),
            'date'       => (new RapidCityTime())->toDateString(),
            'entry_id'   => $entry->getId(),
            'member_id'  => $member->getId(),
            'product_id' => $sku->getId(),
        ];
        if ($this->connection->insert('package_delivery_transactions', $data)) {
            return true;
        }

        return false;
    }
}
