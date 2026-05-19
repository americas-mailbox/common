<?php
declare(strict_types=1);

namespace AMB\Entity\Parcel;

use MyCLabs\Enum\Enum;

enum ParcelStatus : string
{
    case TO_SHIP = 'toShip';
}
