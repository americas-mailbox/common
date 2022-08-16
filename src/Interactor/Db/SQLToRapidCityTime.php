<?php
declare(strict_types=1);

namespace AMB\Interactor\Db;

use AMB\Interactor\RapidCityTime;

final class SQLToRapidCityTime
{
    public function __invoke($value = null): ?RapidCityTime
    {
        return $value ? new RapidCityTime($value) : null;
    }
}
