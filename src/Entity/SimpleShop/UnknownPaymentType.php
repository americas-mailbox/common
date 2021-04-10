<?php
declare(strict_types=1);

namespace AMB\Entity\SimpleShop;

use IamPersistent\SimpleShop\Entity\PaymentMethodInterface;

final class UnknownPaymentType implements PaymentMethodInterface
{
    public function getId()
    {
        return null;
    }

    public function getPaymentMethodType(): string
    {
        return 'unknown';
    }

    public function getDisplaySummary(): string
    {
        return 'Unknown payment type';
    }
}
