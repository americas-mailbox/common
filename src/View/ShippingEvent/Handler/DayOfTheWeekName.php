<?php
declare(strict_types=1);

namespace AMB\Interactor\View\ShippingEvent\Handler;

use AMB\Entity\Shipping\DayOfTheWeek;

final class DayOfTheWeekName
{
    public function __invoke($dayOfTheWeek)
    {
        return $this->get($dayOfTheWeek);
    }

    public function get($dayOfTheWeek): string
    {
        if ($dayOfTheWeek instanceof DayOfTheWeek) {
            $dayOfTheWeek = $dayOfTheWeek->getValue();
        }
        $days = [
            0 => "Sunday",
            1 => "Monday",
            2 => "Tuesday",
            3 => "Wednesday",
            4 => "Thursday",
            5 => "Friday",
            6 => "Saturday",
        ];

        return $days[$dayOfTheWeek];
    }
}
