<?php
declare(strict_types=1);

namespace AMB\Interactor\Parcel;

use AMB\Entity\Member;
use App\Entity\Interfaces\PersonInterface;
use Doctrine\DBAL\Connection;
use IamPersistent\SimpleShop\Entity\Product;

final class AddPkgSkuToTransactionTable
{
    public function __construct(
        private Connection $connection,
    ) {
    }

    public function add(Member $member, Product $sku, ?PersonInterface $actor)
    {
        $data = [
            'admin_id'   => $actor->getId(),
            'member_id'  => $member->getId(),
            'product_id' => $sku->getId(),
        ];
        if ($this->connection->insert('package_delivery_transactions', $data)) {
            return true;
        }

        return false;
    }
}
