<?php
declare(strict_types=1);

use AMB\Entity\Shipping\RecurrenceType;
use Phinx\Migration\AbstractMigration;

final class MigrateRecurrenceDataToEvent extends AbstractMigration
{
    /**
     * Change Method.
     *
     * Write your reversible migrations using this method.
     *
     * More information on writing migrations is available here:
     * https://book.cakephp.org/phinx/0/en/migrations.html#the-change-method
     *
     * Remember to call "create()" or "update()" and NOT "save()" when working
     * with the Table class.
     */
    public function change(): void
    {
        $builder = $this->getQueryBuilder();
        $statement = $builder
            ->select(['id', 'recurrence_id'])
            ->from('shipping_events')
            ->where(function($exp) {
                return $exp->isNotNull('recurrence_id');
            })
            ->execute();
        $values = $statement->fetchAll();
        $recurrenceIds = [];
        $eventIds = [];
        foreach ($values as $value) {
            $recurrenceId= $value[1];
            $eventIds[$recurrenceId] = $value[0];
            $recurrenceIds[] = $recurrenceId;
        }

        $builder = $this->getQueryBuilder();
        $statement = $builder->select('*')->from('shipping_recurrences')->execute();
        $recurrences = $statement->fetchAll('assoc');

        $values = [];
        $counter = 0;
        foreach ($recurrences as $recurrence) {
            $recurrenceId = $recurrence['id'];
            if (!in_array($recurrenceId, $recurrenceIds)) {
                continue;
            }
            $values[] = $this->createValues($eventIds[$recurrenceId], $recurrence);
            $counter++;
            if ($counter > 1000) {
                $this->writeToDB($values);

                $values = [];
                $counter = 0;
            }
        }
        $this->writeToDB($values);

        $this->getQueryBuilder()
            ->update('shipping_events')
            ->set('recurrence_type', RecurrenceType::DOES_NOT_REPEAT)
            ->where (['recurrence_type' => ''])
            ->execute();
    }

    private function writeToDB(array $values)
    {
        if (empty($values)) {
            return;
        }
        $builder = $this->getQueryBuilder();

        $valueData = implode(",\n", $values);

        $sql = <<<SQL
INSERT INTO shipping_events (id, address_id, delivery_id, is_active, member_id,
                             created_at, updated_at, start_date, end_date,
                            daily, day_of_the_month, day_of_the_week, first_weekday_of_the_month,
                             last_weekday_of_the_month, next_weekly, weeks_between, recurrence_type
 ) VALUES
$valueData
ON DUPLICATE KEY UPDATE 
                        daily=VALUES(daily), 
                        day_of_the_month=VALUES(day_of_the_month), 
                        day_of_the_week=VALUES(day_of_the_week), 
                        first_weekday_of_the_month=VALUES(first_weekday_of_the_month), 
                        last_weekday_of_the_month=VALUES(last_weekday_of_the_month), 
                        next_weekly=VALUES(next_weekly), 
                        weeks_between=VALUES(weeks_between), 
                        recurrence_type=VALUES(recurrence_type);
SQL;
        $builder->getConnection()->query($sql);
    }

    private function createValues($id, $recurrenceData): string
    {
        $nullOrInt = function($value) {
            if (empty($value)) {
                return 'NULL';
            }

            return (int) $value;
        };
        $nextWeekly = $recurrenceData['next_weekly'] ? "'{$recurrenceData['next_weekly']}'" : 'NULL';
        $recurrenceType = "'" . $this->getRecurrenceType($recurrenceData) . "'";

        $data = [
            $id,
            1,
            1,
            1,
            1,
            "'2020-02-20 22:07:10'",
            "'2020-02-20 22:07:10'",
            "'2020-02-15'",
            "'2020-02-15'",
            (int)$recurrenceData['daily'],
            $nullOrInt($recurrenceData['day_of_the_month']),
            $nullOrInt($recurrenceData['day_of_the_week']),
            $nullOrInt($recurrenceData['first_weekday_of_the_month']),
            $nullOrInt($recurrenceData['last_weekday_of_the_month']),
            $nextWeekly,
            $nullOrInt($recurrenceData['weeks_between']),
            $recurrenceType,
        ];


        $value = "(" . implode(",", $data) . ")";

        return $value;
    }

    private function getRecurrenceType($data): string
    {
        if (!empty($data['daily'])) {
            return RecurrenceType::DAILY;
        }
        if (1 == $data['weeks_between']) {
            return RecurrenceType::WEEKLY;
        }
        if (!empty($data['next_weekly']) || !empty($data['day_of_the_week'])) {
            return RecurrenceType::INTERMITTENT;
        }
        if (!empty($data['first_weekday_of_the_month'])) {
            return RecurrenceType::FIRST_WEEKDAY_OF_MONTH;
        }
        if (!empty($data['last_weekday_of_the_month'])) {
            return RecurrenceType::LAST_WEEKDAY_OF_MONTH;
        }
        if (!empty($data['day_of_the_month'])) {
            return RecurrenceType::MONTHLY;
        }
    }
}
