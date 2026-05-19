<?php
declare(strict_types=1);

namespace AMB\Entity;

use MyCLabs\Enum\Enum;

enum RenewalFrequency : string
{
    case ANNUAL = 'annual';
    case BIANNUAL = 'biannual';
    case MONTH = 'month';
    case QUARTER = 'quarter';
}
