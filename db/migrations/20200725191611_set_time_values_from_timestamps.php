<?php
declare(strict_types=1);

use Carbon\Carbon;
use Phinx\Migration\AbstractMigration;

final class SetTimeValuesFromTimestamps extends AbstractMigration
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
        $statement = $builder->select('*')->from('shipping_events')->execute();
        $events = $statement->fetchAll('assoc');
        $values = [];
        $counter = 0;
        foreach ($events as $event) {
            unset($event['recurrence_id']);
            $event['start_date'] = (Carbon::createFromTimestamp($event['start_timestamp']))->toDateString();
            $event['end_date'] = (Carbon::createFromTimestamp($event['end_timestamp']))->toDateString();
            $values[] = "('" . implode("','", $event) . "')";
            $counter++;
            if ($counter > 1000) {
                $this->writeToDB($values);

                $values = [];
                $counter = 0;
            }
        }
        $this->writeToDB($values);
    }

    private function writeToDB(array $values)
    {
        if (empty($values)) {
            return;
        }
        $builder = $this->getQueryBuilder();

        $valueData = implode(",\n", $values);
        $sql = <<<SQL
INSERT INTO shipping_events (id, address_id, delivery_id, end_timestamp, is_active, member_id,
                             start_timestamp, created_at, updated_at, start_date, end_date) VALUES
$valueData
ON DUPLICATE KEY UPDATE start_date=VALUES(start_date), end_date=VALUES(end_date);
SQL;
        $builder->getConnection()->query($sql);
    }
}
