<?php
declare(strict_types=1);

namespace AMB\Interactor\Ledger;

use AMB\Entity\Member;
use AMB\Interactor\Admin\ActiveAdmin;
use Exception;
use IamPersistent\Ledger\Entity\Entry;
use IamPersistent\Ledger\Interactor\AddEntryToLedger as BaseAddEntry;
use OLPS\SimpleShop\Interactor\DBal\FindProductById;

final class AddEntryToLedger
{
    /** @var \IamPersistent\Ledger\Interactor\AddEntryToLedger */
    private $addEntryToLedger;

    public function __construct(
        private ActiveAdmin $activeAdmin,
        private FindProductById $findProductById,
        private GetSkuHandlerClass $getHandlerClass,
        private SaveLedger $saveLedger,
    ) {
        $this->addEntryToLedger = new BaseAddEntry();
    }

    public function handle(Member $member, Entry $entry): array
    {
        try {
            $ledger = $member->getLedger();
            $this->addEntryToLedger->handle($ledger, $entry);
            $this->saveLedger->save($ledger, $member);

            foreach($entry->getItems() as $item) {
                $skuId = $item->getProductId();
                $sku = $this->findProductById->find($skuId);
                $this->processSku($member, $entry, $sku);
            }
        } catch (Exception $e) {
            return [
                'success' => false,
                'message' => $e->getMessage(),
            ];
        }

        return [
            'success' => true,
            'message' => 'OK',
        ];
    }

    public function processSku(Member $member, Entry $entry, $sku)
    {
        if ($handlerClass = $this->getHandlerClass->get($sku)) {
            $handlerClass->handle($member, $entry, $sku, $this->activeAdmin->get());
        }
    }

}
