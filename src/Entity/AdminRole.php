<?php
declare(strict_types=1);

namespace AMB\Entity;

use MyCLabs\Enum\Enum;

enum AdminRole : string
{
    case MANAGER = 'manager';
    case MASTER = 'master';
    case STAFF = 'staff';
}