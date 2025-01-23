<?php
declare(strict_types=1);

namespace AMB\Interactor\Parcel;

use AMB\Entity\Member;
use AMB\Interactor\Ledger\AddEntryToLedger;
use AMB\Interactor\Ledger\CreateItemFromProduct;
use AMB\Interactor\RapidCityTime;
use IamPersistent\Ledger\Factory\EntryFactory;
use OLPS\SimpleShop\Entity\Product;

final class ChargeMemberForPackage
{
    public function __construct(
        private AddEntryToLedger $addEntryToLedger,
        private CreateItemFromProduct $createItemFromProduct,
    ) { }

    public function handle(Member $member, Product $packageSku)
    {
        $item = $this->createItemFromProduct->create($packageSku);
        $entry = (new EntryFactory())->createDebitFromItems([$item]);
        $entry
            ->setDate(new RapidCityTime())
            ->setDescription($packageSku->getDescription())
            ->setProductId($packageSku->getId())
            ->setReferenceNumber($packageSku->getName())
            ->setType('Manual');

        return $this->addEntryToLedger->handle($member, $entry);
    }
}
