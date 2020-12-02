<?php
declare(strict_types=1);

namespace AMB\Entity;

use MyCLabs\Enum\Enum;

/**
 * @method static AdminRole MANAGER()
 * @method static AdminRole MASTER()
 * @method static AdminRole STAFF()
 */
final class AdminRole extends Enum
{
    private const MANAGER = 'manager';
    private const MASTER = 'master';
    private const STAFF = 'staff';
}