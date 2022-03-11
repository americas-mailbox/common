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

        for ($year = $startRange; $year < $endRange ; $year++) {
            $yearDates = $dates[$year] ?? [];
            usort($yearDates, $dateSort);
            $dates[$year] = $yearDates;
        }

        return $dates;
    }

    public function getForCalendar(): array
    {
        $closures = $this->get();
        $dates = [];
        foreach ($closures as $year => $closureDates) {
            foreach ($closureDates as $closureDate) {
                $dates[] = [
                    'date' => $closureDate['date'],
                    'reason' => $closureDate['description'],
                ];
            }
        }

        return $dates;
    }
}
