<?php
declare(strict_types=1);

namespace AMB\Interactor\Invoice;

use AMB\Entity\Member;
use AMB\Entity\SiteOptions;
use DateTime;
use IamPersistent\SimpleShop\Entity\Invoice;
use Money\Currency;
use Money\Money;

final class CreateNewInvoice
{
    public function __construct(
        private NextInvoiceNumber $nextInvoiceNumber,
        private SiteOptions $siteOptions
    ) {
    }

    public function create(Member $member, $entrantId = null, string $header = ''): Invoice
    {
        if (is_object($entrantId)) {
            $entrantId = $entrantId->getId();
        }
        $zeroDollars = new Money(0, new Currency('USD'));

        return (new Invoice())
            ->setEntrantId($entrantId)
            ->setHeader($header)
            ->setInvoiceDate(new DateTime())
            ->setInvoiceNumber($this->nextInvoiceNumber->get())
            ->setCurrency(new Currency('USD'))
            ->setTaxRate($this->siteOptions->getTaxRate())
            ->setRecipientId($member->getId())
            ->setSubtotal($zeroDollars)
            ->setTaxes($zeroDollars)
            ->setTotal($zeroDollars);
    }
}
