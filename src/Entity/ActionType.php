<?php
declare(strict_types=1);

namespace AMB\Entity;

use MyCLabs\Enum\Enum;

final class ActionType extends Enum
{
    const CREATED = 'created';
    const UPDATED = 'updated';
    const DELETED = 'deleted';
}
