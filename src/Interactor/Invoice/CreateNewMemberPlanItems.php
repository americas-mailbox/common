<?php
declare(strict_types=1);

namespace AMB\Interactor\Invoice;

use AMB\Entity\Plan;
use AMB\Interactor\Plan\FindPlanByStartingSku;
use AMB\Interactor\RapidCityTime;
use OLPS\SimpleShop\Entity\InvoiceItem;
use OLPS\SimpleShop\Entity\Product;
use OLPS\SimpleShop\Interactor\DBal\FindProductByName;

final class CreateNewMemberPlanItems
{
    public function __construct(
        private CreateProratedPlanItem $createProratedPlanItem,
        private FindPlanByStartingSku $findPlanBySku,
        private FindProductByName $findSkuByName,
    ) {}

    public function create(Product $planSku, RapidCityTime $startDate): array
    {
        $plan = $this->findPlanBySku->find($planSku->getName());
        $items = [
            $this->getPlanItem($planSku),
            $this->getApplicationFee(),
        ];
        if ($prorateItem = $this->createProratedPlanItem->create($plan, $startDate)) {
            $items[] = $prorateItem;
        }
        $items[] = $this->getEscrowDeposit($plan);

        return $items;
    }

    private function getApplicationFee(): InvoiceItem
    {
        $prorateSku = $this->findSkuByName->find('START_01');

        return (new CreateInvoiceItemFromSku())($prorateSku);
    }

    private function getEscrowDeposit(Plan $plan): InvoiceItem
    {
        $escrowSku = $this->findSkuByName->find('POSTAGE_&_SERV_FUND');
        $item = (new CreateInvoiceItemFromSku())($escrowSku);

        $item
            ->setAmount($plan->getMinimumStartingBalance())
            ->setTotalAmount($plan->getMinimumStartingBalance());

        return $item;
    }

    private function getPlanItem(Product $sku): InvoiceItem
    {
        return (new CreateInvoiceItemFromSku())($sku);
    }
}
