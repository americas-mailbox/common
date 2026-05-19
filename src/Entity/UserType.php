<?php
declare(strict_types=1);

namespace AMB\Entity;

use MyCLabs\Enum\Enum;

enum UserType : string
{
    case ADMIN = 'admin';
    case MEMBER = 'member';
    case SYSTEM = 'system';
    case UNKNOWN = 'unknown';
}
