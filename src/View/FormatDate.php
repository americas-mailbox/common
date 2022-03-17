<?php
declare(strict_types=1);

namespace AMB\View;

use AMB\Interactor\RapidCityTime;
use Carbon\Carbon;

final class FormatDate
{
    public function __invoke($date = null, string $format = 'default'): string
    {
        if (!$date instanceof Carbon) {
            $date = new RapidCityTime($date);
        }

        $formatMethod = 'format'. ucfirst($format);

        return $this->$formatMethod($date);
    }

    public function formatDefault(Carbon $date): string
    {
        return Carbon::instance($date)->toDateString();
    }

    public function formatLong(Carbon $date): string
    {
        return $date->format('D, M j, Y');
    }
}
