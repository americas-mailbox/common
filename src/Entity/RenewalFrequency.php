<?php
declare(strict_types=1);

namespace AMB\Entity;

use MyCLabs\Enum\Enum;

final class RenewalFrequency extends Enum
{
    const ANNUAL = 'annual';
    const BIANNUAL = 'biannual';
    const MONTH = 'month';
    const QUARTER = 'quarter';
}
