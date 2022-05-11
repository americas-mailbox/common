<?php
declare(strict_types=1);

namespace AMB\Interactor\Finance;

use AMB\Entity\SiteOptions;
use Money\Money;

final class CalculateConvenienceFee
{
    public function __construct(
        private SiteOptions $siteOptions,
    ) { }

    public function handle(Money $amount): Money
    {
        $convenienceFee = $this->siteOptions->getConvenienceFee();
        $convenienceBaseFee = $this->siteOptions->getConvenienceBaseFee();
        $subTotal = $amount->multiply($convenienceFee)->add($convenienceBaseFee);

        return $subTotal;
    }
}
