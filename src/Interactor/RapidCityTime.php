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

    public static function firstOfTheMonth(): RapidCityTime
    {
        $today = self::today();

        return $today->firstOfMonth();
    }

    public static function endOfToday(): RapidCityTime
    {
        $today = self::today();

        return $today->endOfDay();
    }
}
