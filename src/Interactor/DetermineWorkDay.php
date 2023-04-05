<?php
declare(strict_types=1);

namespace AMB\Interactor;

use Carbon\Carbon;
use Doctrine\DBAL\Connection;

final class DetermineWorkDay
{
    public function __construct(
        private Connection $connection,
    ) { }

    public function is(Carbon $date): bool
    {
        if (6 === $date->dayOfWeek || 0 === $date->dayOfWeek) {
            return false;
        }

        return !(bool) $this->connection->fetchOne("SELECT `date` FROM office_closures WHERE `date`='"
            .$date->toDateString()."'");
    }
    public function isAfterEmergencyClosure(Carbon $startDate, Carbon $endDate): bool
    {
        $sql = <<<SQL
SELECT `date` 
FROM office_closures
WHERE `date`>='{$startDate->toDateString()}'
AND `date`<='{$endDate->toDateString()}'
AND `emergency_closure`=1
SQL;


        return (bool) $this->connection->fetchOne($sql);
    }
}
