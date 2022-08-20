<?php
declare(strict_types=1);

namespace AMB\Interactor\Invoice;

use AMB\Entity\Member;
use IamPersistent\SimpleShop\Entity\Invoice;
use IamPersistent\SimpleShop\Interactor\DBal\FindProductByName;
use Money\Money;

final class CreateTopUpAccountInvoice
{
    /** @var \AMB\Interactor\Invoice\AddConvenienceFeeItem */
    private $addConvenienceFeeItem;
    /** @var \AMB\Interactor\Invoice\CreateNewInvoice */
    private $createNewInvoice;
    /** @var \IamPersistent\SimpleShop\Interactor\DBal\FindProductByName */
    private $findProductByName;

    public function __construct(
        AddConvenienceFeeItem $addConvenienceFeeItem,
        CreateNewInvoice $createNewInvoice,
        FindProductByName $findProductByName
    ) {
        $this->addConvenienceFeeItem = $addConvenienceFeeItem;
        $this->createNewInvoice = $createNewInvoice;
        $this->findProductByName = $findProductByName;
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
