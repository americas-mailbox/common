<?php
declare(strict_types=1);

namespace AMB\Interactor\Ledger;

use IamPersistent\Ledger\Entity\Item;
use OLPS\SimpleShop\Interactor\DBal\FindProductByName;

final class CreateItemFromSKU
{
    public function __construct(
        private CreateItemFromProduct $createItemFromProduct,
        private FindProductByName $findProductBySKU,
    ) { }

    public function create(string $sku): Item
    {
        $product = $this->findProductBySKU->find($sku);

        return $this->createItemFromProduct->create($product);
    }
}
