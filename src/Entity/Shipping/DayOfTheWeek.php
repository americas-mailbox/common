<?php
declare(strict_types=1);

namespace AMB\Entity\Shipping;

use MyCLabs\Enum\Enum;

final class DayOfTheWeek extends Enum
{
    const SUNDAY = 0;
    const MONDAY = 1;
    const TUESDAY = 2;
    const WEDNESDAY = 3;
    const THURSDAY = 4;
    const FRIDAY = 5;
    const SATURDAY = 6;
}
