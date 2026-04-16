<?php
declare(strict_types=1);

namespace Helper\Mock;

use AMB\Interactor\OfficeClosure\IsOfficeClosedInterface;
use AMB\Interactor\RapidCityTime;

final class IsOfficeClosed implements IsOfficeClosedInterface
{
    public function on(RapidCityTime $date): bool
    {
        return $date->isWeekend();
    }
}
