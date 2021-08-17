<?php
declare(strict_types=1);

namespace AMB\Interactor\Ledger\Accounting;

use AMB\Entity\Member;
use AMB\Interactor\Ledger\SkuHandlerInterface;
use AMB\Interactor\Parcel\AddPkgSkuToTransactionTable;
use App\Entity\Interfaces\PersonInterface;
use IamPersistent\Ledger\Entity\Entry;
use IamPersistent\SimpleShop\Entity\Product;

final class HandlePkg implements SkuHandlerInterface
{
    public function __construct(
        private AddPkgSkuToTransactionTable $addPkgToTable,
    ) {}

    public function handle(Member $member, Entry $entry, Product $sku, ?PersonInterface $actor): bool
    {
        return $this->addPkgToTable->add($member, $entry, $sku, $actor);
    }
}
