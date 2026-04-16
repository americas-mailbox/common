<?php
declare(strict_types=1);

namespace AMB\Interactor\OfficeClosure;

use AMB\Interactor\RapidCityTime;

interface IsOfficeClosedInterface
{
    public function on(RapidCityTime $date): bool;
}
