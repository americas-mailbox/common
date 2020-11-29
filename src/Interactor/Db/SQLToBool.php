<?php
declare(strict_types=1);

namespace AMB\Interactor\Db;

final class SQLToBool
{
    public function __invoke($value): bool
    {
        return (bool) $value;
    }
}
