<?php
declare(strict_types=1);

namespace AMB\Entity\Parcel;

use MyCLabs\Enum\Enum;

/**
 * @method static ParcelStatus TO_SHIP()
 */
final class ParcelStatus extends Enum
{
    const TO_SHIP = 'toShip';
}
