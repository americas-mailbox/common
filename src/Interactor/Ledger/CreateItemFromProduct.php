<?php
declare(strict_types=1);

namespace AMB\Interactor\Ledger;

use AMB\Entity\SiteOptions;
use IamPersistent\Ledger\Entity\Item;
use OLPS\SimpleShop\Entity\Product;
use Money\Currency;
use Money\Money;

final class CreateItemFromProduct
{
    public function __construct(
        private SiteOptions $siteOptions,
    ) { }

    public function create(Product $product): Item
    {
        $amount = $product->getPrice();
        if ($product->isTaxable()) {
            $taxes = $amount->multiply($this->siteOptions->getTaxRate());
        } else {
            $taxes = new Money(0, new Currency('USD'));
        }
        $total = $amount->add($taxes);

        return (new Item())
            ->setAmount($amount)
            ->setDescription($product->getDescription())
            ->setProductId($product->getId())
            ->setReferenceNumber($product->getName())
            ->setTaxes($taxes)
            ->setTotal($total);
    }
}
