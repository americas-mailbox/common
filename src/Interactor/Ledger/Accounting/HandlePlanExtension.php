<?php
declare(strict_types=1);

namespace AMB\Interactor\Ledger\Accounting;

use AMB\Entity\Member;
use AMB\Interactor\Ledger\SkuHandlerInterface;
use AMB\Interactor\Plan\HandlePlanExtensionSku;
use IamPersistent\Ledger\Entity\Entry;
use OLPS\SimpleShop\Entity\Product;
use Zestic\Contracts\User\UserInterface;

final class HandlePlanExtension implements SkuHandlerInterface
{
    public function __construct(
        private HandlePlanExtensionSku $handlePlanExtensionSku,
    ) {
    }

    public function handle(Member $member, Entry $entry, Product $sku, ?UserInterface $actor): bool
    {
        $this->handlePlanExtensionSku->handle($member, $sku);

        return true;
    }
}
