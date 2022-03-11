<?php
declare(strict_types=1);

namespace AMB\Interactor\OfficeClosure;

use AMB\Interactor\RapidCityTime;
use Doctrine\DBAL\Connection;

final class GetOfficeClosureDates
{
    public function __construct(
        private Connection $connection,
    ) {}

    public function get(): array
    {
        $thisYear = (new RapidCityTime())->firstOfYear();
        $startRange = $thisYear->year;
        $endRange = $startRange + 5;

        $startingYear = $thisYear->toDateString();
        $data = $this->connection->fetchAllAssociative("SELECT * FROM office_closures WHERE `date` >= '$startingYear'");

        $dates = [];

        foreach ($data as $datum) {
            $year = (new RapidCityTime($datum['date']))->year;
            $dates[$year][] = $datum;
        }

        $dateSort = function ($a, $b) {
            return $a['date'] <=> $b['date'];
        };

        for( $year = $startRange; $year < $endRange ; $year++) {
            $yearDates = $dates[$year] ?? [];
            usort($yearDates, $dateSort);
            $dates[$year] = $yearDates;
        }

        return $dates;
    }

    public function getForCalendar(): string
    {
        $thisYear = (new RapidCityTime())->firstOfYear();
        $startingYear = $thisYear->toDateString();
        $data = $this->connection->fetchAllAssociative("SELECT `date` FROM office_closures WHERE `date` >= '$startingYear'");

        $dates = [];
        foreach ($data as $datum) {
            $dates[] = '"' . (new RapidCityTime($datum['date']))->format('m/d/Y') . '"';
        }

        return implode(" ,\n", $dates);
    }
}
