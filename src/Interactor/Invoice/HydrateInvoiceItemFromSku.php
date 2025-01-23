<?php
declare(strict_types=1);

namespace AMB\Interactor\Invoice;

use OLPS\SimpleShop\Entity\InvoiceItem;
use OLPS\SimpleShop\Entity\Product;

final class HydrateInvoiceItemFromSku
{
    public function __invoke(InvoiceItem $item, Product $sku, $quantity = 1)
    {
        $amount = $sku->getPrice();
        $total = $amount->multiply((string)$quantity);

        $item
            ->setAmount($amount)
            ->setDescription($sku->getDescription())
            ->setQuantity($quantity)
            ->setProduct($sku)
            ->setIsTaxable($sku->isTaxable())
            ->setTotalAmount($total);
    }
}
