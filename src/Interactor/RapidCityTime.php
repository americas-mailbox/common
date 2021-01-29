<?php
declare(strict_types=1);

namespace AMB\Interactor;

use Carbon\Carbon;

final class RapidCityTime extends Carbon
{
    public function __construct($time = null, $tz = null)
    {
        $tz = 'America/Denver';
        parent::__construct($time, $tz);
    }
}
