<?php
declare(strict_types=1);

namespace AMB\Interactor\Shipping;

use AMB\Entity\Shipping\RecurrenceType;
use AMB\Interactor\DetermineWorkDay;
use AMB\Interactor\RapidCityTime;
use Carbon\Carbon;
use Doctrine\DBAL\Connection;
use IamPersistent\SimpleShop\Interactor\CamelCase;

final class GetNextScheduledDelivery
{
    /** @var Connection */
    protected $connection;
    /** @var DetermineWorkDay */
    private $determineWorkDay;

    public function __construct(Connection $connection, DetermineWorkDay $determineWorkDay)
    {
        $this->connection = $connection;
        $this->determineWorkDay = $determineWorkDay;
    }

    public function get($memberId, Carbon $date = null): ?array
    {
        if (!$date) {
            $date = RapidCityTime::today();
        } else {
            $date = (RapidCityTime::instance($date))->startOfDay();
        }

        $oneTimeEvent = $this->getSoonestOneTimeEvent($memberId, $date);
        if ($this->shippingEventMatchesDate($oneTimeEvent, $date)) {
            return $oneTimeEvent;
        }

        if (!$recurringEvent = $this->getSoonestRecurringEvent($memberId, $date)) {
            return $oneTimeEvent;
        }

        return $this->returnSoonestEvent($recurringEvent, $oneTimeEvent);
    }

    private function getRecurringEventData($memberId, Carbon $todaysDate): ?array
    {
        $recurrenceType = RecurrenceType::DOES_NOT_REPEAT;
        $sql = <<<SQL
SELECT 
    e.id,
    e.recurrence_type,
    e.start_date,     
    e.end_date,
    e.daily,
    e.day_of_the_month,
    e.day_of_the_week,
    e.first_weekday_of_the_month,
    e.last_weekday_of_the_month,
    e.next_weekly,
    e.weeks_between,
    a.id as addressId,
    d.id as deliveryMethodId,
    d.label AS deliveryMethod,
    d.group AS deliveryGroup,
    a.addressee,    
    a.street_1 AS street1,       
    a.street_2 AS street2,       
    a.street_3 AS street3,       
    a.city,          
    a.state,         
    a.post_code AS postCode,      
    a.country        
FROM shipping_events AS e
LEFT JOIN delivery_methods AS d ON e.delivery_id = d.id
LEFT JOIN addresses AS a on e.address_id = a.id
WHERE e.member_id = $memberId
    AND recurrence_type != '$recurrenceType'
    AND end_date >= '{$todaysDate->toDateString()}'
    AND e.is_active = 1
ORDER BY start_date ASC
SQL;
        $data = $this->connection->fetchAll($sql);
        if (empty($data)) {
            return null;
        }

        return $data;
    }

    private function getSoonestRecurringEvent($memberId, Carbon $todaysDate): ?array
    {
        if (!$data = $this->getRecurringEventData($memberId, $todaysDate)) {
            return null;
        }

        $data = $this->normalizeData($data);
        $shipment = [
            'date'             => new RapidCityTime('2200-01-01'),
            'deliveryMethod'   => null,
            'deliveryMethodId' => null,
            'deliveryGroup'    => null,
            'addressee'        => null,
            'street1'          => null,
            'street2'          => null,
            'street3'          => null,
            'city'             => null,
            'state'            => null,
            'postCode'         => null,
            'country'          => null,
        ];
        $shipment = null;
        $shippingDate = new RapidCityTime('2200-01-01');
        foreach ($data as $datum) {
            $recurringDate = $this->determineNextRecurringDelivery($datum, $todaysDate);
            if ($recurringDate->eq($todaysDate)) {
                return $this->createShipment($datum, $recurringDate);
            }

            if ($recurringDate->lt($shippingDate)) {
                $shipment = $this->createShipment($datum, $recurringDate);
                $shippingDate = $recurringDate->clone();
            }
        }

        return $shipment;
    }

    private function createShipment(array $datum, Carbon $date): array
    {
        return [
            'date'             => $this->getShipmentDate($date)->toDateString(),
            'deliveryMethod'   => $datum['deliveryMethod'],
            'deliveryMethodId' => $datum['deliveryMethodId'],
            'deliveryGroup'    => $datum['deliveryGroup'],
            'addressee'        => $datum['addressee'],
            'street1'          => $datum['street1'],
            'street2'          => $datum['street2'],
            'street3'          => $datum['street3'],
            'city'             => $datum['city'],
            'state'            => $datum['state'],
            'postCode'         => $datum['postCode'],
            'country'          => $datum['country'],
        ];
    }

    private function determineNextDailyDelivery(array $data, Carbon $date): Carbon
    {
        if ($date->gt($data['startDate'])) {
            return $date;
        }

        return $data['startDate'];
    }

    private function determineNextIntermittentDelivery(array $data, Carbon $date): Carbon
    {
        return $data['next_weekly'];
    }

    private function determineNextFirstWeekdayOfMonthDelivery(array $data, Carbon $requestedDate): Carbon
    {
        $dayOfTheWeek = (int)$data['first_weekday_of_the_month'];
        $date = $this->getDayOfMonth('first', $dayOfTheWeek, $requestedDate);
        if ($date->lt($requestedDate)) {
            return $this->getDayOfMonth('first', $dayOfTheWeek, $date->addMonthNoOverflow());
        }

        $date = $this->getDayOfMonth('first', $dayOfTheWeek, $data['startDate']);
        if ($date->lt($data['startDate'])) {
            return $this->getDayOfMonth('first', $dayOfTheWeek, $date->addMonthNoOverflow());
        }

        return $date;
    }

    private function determineNextLastWeekdayOfMonthDelivery(array $data, Carbon $requestedDate): Carbon
    {
        $dayOfTheWeek = (int)$data['last_weekday_of_the_month'];
        $date = $this->getDayOfMonth('last', $dayOfTheWeek, $requestedDate);
        if ($date->lt($data['startDate'])) {
            $date = $this->getDayOfMonth('last', $dayOfTheWeek, $data['startDate']);
        }

        return $date;
    }

    private function determineNextMonthlyDelivery(array $data, Carbon $requestedDate): Carbon
    {
        $dayOfTheMonth = (int)$data['day_of_the_month'];
        $year = $requestedDate->year;
        $month = $requestedDate->month;
        $date = Carbon::create($year, $month, $dayOfTheMonth, 0, 0, 0, 'America/Denver');
        if ($requestedDate->gte($date)) {
            return $date->addMonthNoOverflow();
        }

        $year = $data['startDate']->year;
        $month = $data['startDate']->month;
        $startingDate = Carbon::create($year, $month, $dayOfTheMonth, 0, 0, 0, 'America/Denver');
        if ($date->gte($startingDate)) {
            return $date;
        }

        if ($startingDate->lt($data['startDate'])) {
            return $startingDate->addMonthNoOverflow();
        }

        return $startingDate;
    }

    private function determineNextWeeklyDelivery(array $data, Carbon $date): Carbon
    {
        if ($date->lt($data['startDate'])) {
            $date = $data['startDate'];
        }
        if ($date->dayOfWeek === $data['day_of_the_week']) {
            return $date;
        }

        return $date->next($data['day_of_the_week']);
    }

    private function determineNextRecurringDelivery(array $data, Carbon $todaysDate): Carbon
    {
        $recurringMethod = (new CamelCase())('determineNext_'. $data['recurrence_type'] . 'Delivery');
        $workingDate = $todaysDate->clone();

        return $this->$recurringMethod($data, $workingDate);
    }

    private function getSoonestOneTimeEvent($memberId, RapidCityTime $date): ?array
    {
        $recurrenceType = RecurrenceType::DOES_NOT_REPEAT;

        $sql = <<<SQL
SELECT 
    start_date,     
    end_date,
    a.id as addressId,
    d.id as deliveryMethodId,
    d.label AS deliveryMethod,
    d.group AS deliveryGroup,
    a.addressee,    
    a.street_1 AS street1,       
    a.street_2 AS street2,       
    a.street_3 AS street3,       
    a.city,          
    a.state,         
    a.post_code AS postCode,      
    a.country        
FROM shipping_events AS e
LEFT JOIN delivery_methods AS d ON e.delivery_id = d.id
LEFT JOIN addresses AS a on e.address_id = a.id
WHERE e.member_id = $memberId
  AND start_date = end_date
  AND start_date >= '{$date->toDateString()}'
  AND recurrence_type = '$recurrenceType'
  AND e.is_active = 1
  ORDER BY start_date ASC
LIMIT 1
SQL;
        $data = $this->connection->fetchAssoc($sql);
        if (empty($data)) {
            return null;
        }

        return $this->createShipment($data, new RapidCityTime($data['start_date']));
    }

    private function getDayOfMonth($timeOfMonth, $weekdayNumber, Carbon $compareDate)
    {
        $weekday = $this->getDayOfTheWeek((int) $weekdayNumber);
        $month = $compareDate->format('Y-m');
        $dayOfWeekString = "$timeOfMonth $weekday of $month";

        return Carbon::createFromTimestamp(strtotime($dayOfWeekString));
    }

    private function getDayOfTheWeek($day): string
    {
        $daysOfTheWeek = [
            1 => 'monday',
            2 => 'tuesday',
            3 => 'wednesday',
            4 => 'thursday',
            5 => 'friday',
        ];

        return $daysOfTheWeek[$day];
    }

    private function getShipmentDate(Carbon $shipmentDate): Carbon
    {
        $date = $shipmentDate->clone();
        while (false === $this->determineWorkDay->is($date)) {
            $date->addDay();
        }

        return $date;
    }

    private function normalizeData(array $data): array
    {
        $normalized = [];
        $intOrNull = function($value) {
            return $value ? (int) $value : null;
        };
        foreach ($data as $datum) {
            $nextWeekly = $datum['next_weekly'] ? new RapidCityTime($datum['next_weekly']) : null;
            $normalized[] = [
                'startDate'                  => new RapidCityTime($datum['start_date']),
                'endDate'                    => new RapidCityTime($datum['end_date']),
                'id'                         => (int)$datum['id'],
                'recurrence_type'            => $datum['recurrence_type'],
                'daily'                      => (int)$datum['daily'],
                'day_of_the_month'           => $intOrNull($datum['day_of_the_month']),
                'day_of_the_week'            => $intOrNull($datum['day_of_the_week']),
                'first_weekday_of_the_month' => $intOrNull($datum['first_weekday_of_the_month']),
                'last_weekday_of_the_month'  => $intOrNull($datum['last_weekday_of_the_month']),
                'next_weekly'                => $nextWeekly,
                'weeks_between'              => $intOrNull($datum['weeks_between']),
                'addressId'                  => $intOrNull($datum['addressId']),
                'deliveryMethod'             => $datum['deliveryMethod'],
                'deliveryMethodId'           => $datum['deliveryMethodId'],
                'deliveryGroup'              => $datum['deliveryGroup'],
                'addressee'                  => $datum['addressee'],
                'street1'                    => $datum['street1'],
                'street2'                    => $datum['street2'],
                'street3'                    => $datum['street3'],
                'city'                       => $datum['city'],
                'state'                      => $datum['state'],
                'postCode'                   => $datum['postCode'],
                'country'                    => $datum['country'],
            ];
        }

        return $normalized;
    }

    private function returnSoonestEvent(array $eventA, array $eventB = null): array
    {
        if (empty($eventB)) {
            return $eventA;
        }

        if ((new RapidCityTime($eventA['date']))->gt(new RapidCityTime($eventB['date']))) {
            return $eventB;
        }

        return $eventA;
    }

    private function shippingEventMatchesDate(array $event = null, RapidCityTime $date): bool
    {
        if (empty($event)) {
            return false;
        }

        return $date->eq(new RapidCityTime($event['date']));
    }
}
