<?php

declare(strict_types=1);

namespace AMB\Interactor\Invoice;

use AMB\Interactor\RapidCityTime;
use OLPS\SimpleShop\Entity\Invoice;
use OLPS\SimpleShop\Interactor\DBal\FindProductByName;

final class CreateNewSignupInvoice
{
    public function __construct(
        private AddConvenienceFeeItem $addConvenienceFeeItem,
        private CreateNewInvoiceWithoutMember $createNewInvoiceWithoutMember,
        private CreateNewMemberPlanItems $createNewMemberPlanItems,
        private FindProductByName $findSkuByName,
    ) { }

    public function create(string $sku): Invoice
    {
        $planSku = $this->findSkuByName->find($sku);
        $items = $this->createNewMemberPlanItems->create($planSku, new RapidCityTime());
        $invoice = $this->createNewInvoiceWithoutMember->create();
        $invoice->setItems($items);
        $this->addConvenienceFeeItem->addItem($invoice);

        return $invoice;
    }
}
