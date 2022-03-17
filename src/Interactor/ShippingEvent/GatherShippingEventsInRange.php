<?php
declare(strict_types=1);

namespace AMB\Interactor\ShippingEvent;

use Carbon\Carbon;

final class GatherShippingEventsInRange extends GatherShippingEvents
{
    /** @var \Carbon\Carbon */
    private $endDate;
    /** @var mixed */
    private $memberId;
    /** @var \Carbon\Carbon */
    private $startDate;

    public function gather($memberId, Carbon $startDate, Carbon $endDate = null): ?array
    {
        if (!$endDate) {
            $endDate = $startDate->clone();
        }
        $this->endDate = $endDate;
        $this->memberId = $memberId;
        $this->startDate = $startDate;

        return $this->handle();
    }

    protected function sql(): string
    {
        return (new SelectShippingEventSQL)() . <<<SQL
WHERE e.member_id = $this->memberId
    AND start_date <= '{$this->startDate->toDateString()}'
    AND end_date >= '{$this->endDate->toDateString()}'
    AND e.is_active = 1
ORDER BY start_date
SQL;
    }
}
