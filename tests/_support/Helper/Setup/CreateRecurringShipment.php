<?php
declare(strict_types=1);

namespace Helper\Setup;

use AMB\Entity\Shipping\ShippingEvent;
use AMB\Interactor\RapidCityTime;
use Carbon\Carbon;
use Helper\Mock\SaveShippingEvent;

final class CreateRecurringShipment
{
    /** @var \Helper\Mock\SaveShippingEvent */
    private $saveShippingEvent;

    public function __construct(SaveShippingEvent $saveShippingEvent)
    {
        $this->saveShippingEvent = $saveShippingEvent;
    }

    public function daily(
        Carbon $startDate = null,
        Carbon $endDate = null
    ): ShippingEvent {
        if (!$startDate) {
            $startDate = new RapidCityTime('2020-01-29');
        }
        if (!$endDate) {
            $endDate = new RapidCityTime('2020-02-26');
        }
        $shippingEvent = (new ShippingEvent())
            ->setActive(true)
            ->setDaily(true)
            ->setEndDate($endDate)
            ->setStartDate($startDate);
        $this->saveShippingEvent->save($shippingEvent);

        return $shippingEvent;
    }

    public function weekly(
        Carbon $startDate,
        Carbon $endDate,
        Carbon $nextWeekly = null
    ): ShippingEvent {
        return $this->recurring(1, $startDate, $endDate, $nextWeekly);
    }

    public function recurring(
        int $weeksBetween,
        Carbon $startDate,
        Carbon $endDate,
        Carbon $nextWeekly = null
    ): ShippingEvent {
        if (!$nextWeekly) {
            $nextWeekly = $startDate->clone();
        }
        $shippingEvent = (new ShippingEvent())
            ->setActive(true)
            ->setEndDate($endDate)
            ->setStartDate($startDate)
            ->setNextWeekly($nextWeekly)
            ->setWeeksBetween($weeksBetween);
        $this->saveShippingEvent->save($shippingEvent);

        return $shippingEvent;
    }
}
