<?php
declare(strict_types=1);

namespace AMB\Transformer;

use AMB\Entity\Admin;
use AMB\Entity\Member;
use IamPersistent\Money\Interactor\MoneyToArray;
use IamPersistent\SimpleShop\Entity\Invoice;

final class TransformInvoice
{
    public function transform(Invoice $invoice, Member $member, ?Admin $admin = null)
    {
        $moneyToArray = (new MoneyToArray());

        return [
            'entrant'       => $this->getEntrant($admin),
            'entrantId'     => $invoice->getEntrantId(),
            'items'         => $this->getFormattedItems($invoice),
            'id'            => $invoice->getId(),
            'invoiceDate'   => $invoice->getInvoiceDate()->format('Y-m-d'),
            'invoiceNumber' => $invoice->getInvoiceNumber(),
            'paid'          => $this->getFormattedPaid($invoice),
            'recipient'     => [
                'firstName'  => $member->getFirstName(),
                'id'         => $member->getId(),
                'middleName' => $member->getMiddleName(),
                'lastName'   => $member->getLastName(),
                'pmb'        => $member->getPMB(),
            ],
            'recipientId'   => $invoice->getRecipientId(),
            'subtotal'      => $moneyToArray($invoice->getSubtotal()),
            'taxes'         => $moneyToArray($invoice->getTaxes()),
            'taxRate'       => $invoice->getTaxRate(),
            'total'         => $moneyToArray($invoice->getTotal()),
        ];
    }

    public function transformWithoutMember(Invoice $invoice)
    {
        $moneyToArray = (new MoneyToArray());

        return [
            'entrant'       => '',
            'entrantId'     => $invoice->getEntrantId(),
            'items'         => $this->getFormattedItemsForSignupInvoice($invoice),
            'id'            => $invoice->getId(),
            'invoiceDate'   => $invoice->getInvoiceDate()->format('Y-m-d'),
            'invoiceNumber' => $invoice->getInvoiceNumber(),
            'paid'          => $this->getFormattedPaid($invoice),
            'recipient'     => '',
            'recipientId'   => $invoice->getRecipientId(),
            'subtotal'      => $moneyToArray($invoice->getSubtotal()),
            'taxes'         => $moneyToArray($invoice->getTaxes()),
            'taxRate'       => $invoice->getTaxRate(),
            'total'         => $moneyToArray($invoice->getTotal()),
        ];
    }

    private function getEntrant(?Admin $admin): array
    {
        return [
            'id'       => $admin ? $admin->getId() : null,
            'username' => $admin ? $admin->getUsername() : null,
        ];
    }

    private function getFormattedItems(Invoice $invoice): array
    {
        $items = [];
        $moneyToArray = (new MoneyToArray());
        $transformProduct = (new TransformProduct());
        foreach ($invoice->getItems() as $item) {
            $product = $item->getProduct();
            $items[] = [
                'amount'      => $moneyToArray($item->getAmount()),
                'description' => $item->getDescription(),
                'id'          => $item->getId(),
                'isTaxable'   => $item->isTaxable(),
                'product'     => $transformProduct->transform($product),
                'quantity'    => $item->getQuantity(),
                'sku'         => $product->getName(),
                'total'       => $moneyToArray($item->getTotalAmount()),
            ];
        }

        return $items;
    }

    private function getFormattedItemsForSignupInvoice(Invoice $invoice): array
    {
        $items = [];
        $moneyToArray = (new MoneyToArray());
        foreach ($invoice->getItems() as $item) {
            $items[] = [
                'amount'      => $moneyToArray($item->getAmount()),
                'description' => $item->getDescription(),
                'id'          => $item->getId(),
                'isTaxable'   => $item->isTaxable(),
                'product'     => $item->getProduct(),
                'quantity'    => $item->getQuantity(),
                'sku'         => $item->getProduct()->getName(),
                'total'       => $moneyToArray($item->getTotalAmount()),
            ];
        }

        return $items;
    }

    private function getFormattedPaid(Invoice $invoice): array
    {
        return [];
    }
}
