<?php
declare(strict_types=1);

namespace AMB\Entity;

use MyCLabs\Enum\Enum;

final class UserType extends Enum
{
    const ADMIN = 'admin';
    const MEMBER = 'member';
    const SYSTEM = 'system';
    const UNKNOWN = 'unknown';
}
