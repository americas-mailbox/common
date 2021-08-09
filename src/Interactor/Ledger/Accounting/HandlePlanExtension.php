<?php
declare(strict_types=1);

namespace AMB\Interactor\Ledger\Accounting;

use AMB\Entity\Member;
use AMB\Interactor\Plan\HandlePlanExtensionSku;
use IamPersistent\SimpleShop\Entity\Product;

final class HandlePlanExtension
{
    /** @var \AMB\Interactor\Plan\HandlePlanExtensionSku */
    private $handlePlanExtensionSku;

    public function __construct(HandlePlanExtensionSku $handlePlanExtensionSku)
    {
        $this->handlePlanExtensionSku = $handlePlanExtensionSku;
    }

    public function handle(Member $member, Product $sku)
    {
        $this->handlePlanExtensionSku->handle($member, $sku);
    }
}
