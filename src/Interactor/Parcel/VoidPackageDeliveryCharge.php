<?php
declare(strict_types=1);

namespace AMB\Interactor\Parcel;

use AMB\Interactor\Ledger\AddEntryToLedger;
use AMB\Interactor\Ledger\CreateItemFromProduct;
use AMB\Interactor\Member\FindMemberById;
use AMB\Interactor\RapidCityTime;
use Doctrine\DBAL\Connection;
use IamPersistent\Ledger\Factory\EntryFactory;
use IamPersistent\SimpleShop\Interactor\DBal\FindProductById;

final class VoidPackageDeliveryCharge
{
    public function __construct(
        private AddEntryToLedger $addEntryToLedger,
        private Connection $connection,
        private CreateItemFromProduct $createItemFromProduct,
        private FindProductById $findProductById,
        private FindMemberById $findMemberById,
    ) {
    }

    public function voidPackageCharge($entryId)
    {
        $sql = <<<SQL
SELECT 
  le.product_id,
  m.member_id
FROM ledger_entries le
LEFT JOIN ledgers l on le.ledger_id = l.id
LEFT JOIN accounts a on l.id = a.ledger_id
LEFT JOIN members m on a.id = m.account_id
WHERE le.id = $entryId
SQL;

        $entryData = $this->connection->fetchAssociative($sql);
        $packageSku = $this->findProductById->find($entryData['product_id']);

        $item = $this->createItemFromProduct->create($packageSku);
        $entry = (new EntryFactory())->createCreditFromItems([$item]);
        $entry
            ->setDate(new RapidCityTime())
            ->setDescription($packageSku->getDescription())
            ->setProductId($packageSku->getId())
            ->setReferenceNumber($packageSku->getName())
            ->setType('Manual');
        $member = $this->findMemberById->find($entryData['member_id']);

        return $this->addEntryToLedger->handle($member, $entry);
    }
}
