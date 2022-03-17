<?php
declare(strict_types=1);

namespace AMB\Interactor\ShippingEvent;

use AMB\Factory\DbalConnection;
use AMB\Interactor\DbalConnectionTrait;
use Carbon\Carbon;

final class DeactivatePastShippingEvents implements DbalConnection
{
    use DbalConnectionTrait;

    public function deactivate(Carbon $date)
    {
        $sql = <<<SQL
UPDATE shipping_events
SET is_active = 0
WHERE end_date <= '{$date->toDateString()}'
  AND is_active = 1
SQL;

        $this->connection->exec($sql);
    }
}
