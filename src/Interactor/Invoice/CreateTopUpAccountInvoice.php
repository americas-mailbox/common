<?php
declare(strict_types=1);

namespace AMB\Interactor\Invoice;

use AMB\Entity\Member;
use OLPS\SimpleShop\Entity\Invoice;
use OLPS\SimpleShop\Interactor\DBal\FindProductByName;
use Money\Money;

final class CreateTopUpAccountInvoice
{
    public function __construct(
        private AddConvenienceFeeItem $addConvenienceFeeItem,
        private CreateNewInvoice $createNewInvoice,
        private FindProductByName $findProductByName
    ) {
    }

    public function handle(Member $member, Money $amount): Invoice
    {
        $invoice = $this->createNewInvoice->create($member, 1, 'Top Up Postage');

        $postageFund = $this->findProductByName->find('POSTAGE_&_SERV_FUND');
        $postageItem = (new CreateInvoiceItemFromSku)($postageFund);
        $postageItem->setAmount($amount);
        $invoice->addItem($postageItem);

        $this->addConvenienceFeeItem->addItem($invoice);

        return $invoice;
    }
}
