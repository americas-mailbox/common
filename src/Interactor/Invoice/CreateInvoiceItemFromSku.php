<?php
declare(strict_types=1);

namespace AMB\Interactor\Invoice;

use IamPersistent\SimpleShop\Entity\InvoiceItem;
use IamPersistent\SimpleShop\Entity\Product;

final class CreateInvoiceItemFromSku
{
    public function __invoke(Product $sku, int $quantity = 1): InvoiceItem
    {
        $item = new InvoiceItem();
        (new HydrateInvoiceItemFromSku)($item, $sku, $quantity);

        return $item;
    }
}
