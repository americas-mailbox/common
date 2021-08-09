<?php
declare(strict_types=1);

namespace AMB\Interactor\Ledger\Accounting;

use AMB\Entity\Member;
use AMB\Interactor\Plan\HandlePlanSku;
use IamPersistent\SimpleShop\Entity\Product;

final class HandlePlan
{
    /** @var \AMB\Interactor\Plan\HandlePlanSku */
    private $handlePlanSku;

    public function __construct(HandlePlanSku $handlePlanSku)
    {
        $this->handlePlanSku = $handlePlanSku;
    }

    public function handle(Member $member, Product $sku)
    {
        $this->handlePlanSku->handle($member, $sku);
    }
}
