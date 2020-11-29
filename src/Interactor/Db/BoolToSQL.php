<?php
declare(strict_types=1);

namespace AMB\Interactor\Db;

final class BoolToSQL
{
    public function __invoke($bool): int
    {
        return (int) $bool;
    }
}
