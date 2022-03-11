<?php
declare(strict_types=1);

namespace AMB\Interactor\OfficeClosure;

use AMB\Interactor\RapidCityTime;
use Doctrine\DBAL\Connection;

final class IsOfficeClosed
{
    /** @var string[] */
    private $closureDates;

    public function __construct(Connection $connection)
    {
        $this->setUpClosureDates($connection);
    }

    public function on(RapidCityTime $date): bool
    {
        if ($date->isWeekend()) {
            return true;
        }
        $date = $date->toDateString();

        return isset($this->closureDates[$date]);
    }

    private function setUpClosureDates(Connection $connection)
    {
        $sql = "SELECT date FROM office_closures;";
        $dates = $connection->fetchFirstColumn($sql);

        foreach ($dates as $date) {
            $this->closureDates[$date] = $date;
        }
    }
}
