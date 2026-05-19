<?php

declare(strict_types=1);

namespace AMB\Entity;

use MyCLabs\Enum\Enum;

enum LegacyMemberStatus : int
{
    // members table have column active.
    case ACTIVE = 1;
    // user can login.
    case CLOSED = 0;
    // user can not login.
    case UNVERIFIED = 2;
    // New member can not login.
    case UNPAID = 3;
}
