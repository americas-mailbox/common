<?php
declare(strict_types=1);

namespace AMB\Interactor\Ledger;

use AMB\Entity\Member;
use IamPersistent\Ledger\Entity\Entry;
use IamPersistent\SimpleShop\Entity\Product;
use Zestic\Contracts\Person\PersonInterface;

interface SkuHandlerInterface
{
    public function handle(Member $member, Entry $entry, Product $sku, ?PersonInterface $actor): bool;
}