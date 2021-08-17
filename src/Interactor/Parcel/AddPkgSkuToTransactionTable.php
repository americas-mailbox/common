<?php
declare(strict_types=1);

namespace AMB\Interactor\Parcel;

use AMB\Entity\Member;
use AMB\Interactor\RapidCityTime;
use App\Entity\Interfaces\PersonInterface;
use Doctrine\DBAL\Connection;
use IamPersistent\Ledger\Entity\Entry;
use IamPersistent\SimpleShop\Entity\Product;

final class AddPkgSkuToTransactionTable
{
    public function __construct(
        private Connection $connection,
    ) {
    }

    public function add(Member $member, Entry $entry, Product $sku, ?PersonInterface $actor)
    {
        $data = [
            'admin_id'   => $actor->getId(),
            'date'       => (new RapidCityTime())->toDateTimeString(),
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
