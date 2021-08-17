<?php
declare(strict_types=1);

namespace AMB\Interactor\Ledger\Accounting;

use AMB\Entity\Member;
use AMB\Interactor\Ledger\SkuHandlerInterface;
use AMB\Interactor\Plan\HandlePlanSku;
use App\Entity\Interfaces\PersonInterface;
use IamPersistent\Ledger\Entity\Entry;
use IamPersistent\SimpleShop\Entity\Product;

final class HandlePlan implements SkuHandlerInterface
{
    public function __construct(
        private HandlePlanSku $handlePlanSku
    ) {
    }

    public function handle(Member $member, Entry $entry, Product $sku, ?PersonInterface $actor): bool
    {
        $this->handlePlanSku->handle($member, $sku);

        return true;
    }
}
