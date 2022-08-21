<?php
declare(strict_types=1);

namespace AMB\Interactor\Invoice;

use AMB\Entity\Member;
use AMB\Entity\Member\Plan;
use IamPersistent\SimpleShop\Entity\Invoice;

final class CreateRenewMembershipInvoice
{
    public function __construct(
        private AddConvenienceFeeItem $addConvenienceFeeItem,
        private CreateNewInvoice $createNewInvoice,
        private SkuPlanLookup $skuLookup
    ) {
    }

    public function handle(Member $member, Plan $plan, $entrantId = 1): Invoice
    {
        $invoice = $this->createNewInvoice->create($member, $entrantId);
        $invoice->setHeader('Renew Membership');

        $sku = $this->skuLookup->getSku($plan, 'renewal', (string) $member->getMemberPlan()->getRenewalFrequency());
        $item = (new CreateInvoiceItemFromSku)($sku);
        $invoice->addItem($item);

        $this->addConvenienceFeeItem->addItem($invoice);

        return $invoice;
    }
}
