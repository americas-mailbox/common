<?php
declare(strict_types=1);

namespace AMB\Interactor\Ledger;

use AMB\Entity\Member;
use App\Entity\Interfaces\PersonInterface;
use IamPersistent\SimpleShop\Entity\Product;

interface SkuHandlerInterface
{
    public function handle(Member $member, Product $sku, ?PersonInterface $actor): bool;
}
