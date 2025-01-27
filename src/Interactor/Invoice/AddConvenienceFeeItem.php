<?php
declare(strict_types=1);

namespace AMB\Interactor\Invoice;

use AMB\Interactor\Finance\CalculateConvenienceFee;
use OLPS\SimpleShop\Entity\Invoice;
use OLPS\SimpleShop\Interactor\DBal\FindProductByName;
use OLPS\SimpleShop\Interactor\TotalInvoice;

final class AddConvenienceFeeItem
{
    public function __construct(
        private CalculateConvenienceFee $calculateConvenienceFee,
        private FindProductByName $findSkuByName,
    ) { }

    public function addItem(Invoice $invoice)
    {
        (new TotalInvoice())->handle($invoice);
        $amount = $this->calculateConvenienceFee->handle($invoice->getSubtotal());

        $sku = $this->findSkuByName->find('CONV_01');
        $item = (new CreateInvoiceItemFromSku())($sku);
        $item
            ->setAmount($amount)
            ->setTotalAmount($amount);

        $invoice->addItem($item);

        (new TotalInvoice())->handle($invoice);
    }
}
