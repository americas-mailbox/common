<?php
declare(strict_types=1);

namespace AMB\Interactor\View\ShippingEvent;

use AMB\Entity\Shipping\ShippingEvent;
use AMB\Interactor\RapidCityTime;
use AMB\Interactor\ShippingEvent\GetScheduledDates;
use AMB\Interactor\View\ShippingEvent\Handler\HandleDaily;
use AMB\Interactor\View\ShippingEvent\Handler\HandleDoesNotRepeat;
use AMB\Interactor\View\ShippingEvent\Handler\HandleFirstWeekdayOfMonth;
use AMB\Interactor\View\ShippingEvent\Handler\HandleIntermittent;
use AMB\Interactor\View\ShippingEvent\Handler\HandleLastWeekdayOfMonth;
use AMB\Interactor\View\ShippingEvent\Handler\HandleMonthly;
use AMB\Interactor\View\ShippingEvent\Handler\HandleWeekly;
use AMB\Interactor\View\ShippingEvent\Handler\SetDateInEventData;
use IamPersistent\SimpleShop\Interactor\CamelCase;

final class GatherFutureEvents
{
    public function __construct(
        private GetScheduledDates $getScheduledDates,
        private HandleDaily $handleDaily,
        private HandleDoesNotRepeat $handleDoesNotRepeat,
        private HandleFirstWeekdayOfMonth $handleFirstWeekdayOfMonth,
        private HandleIntermittent $handleIntermittent,
        private HandleLastWeekdayOfMonth $handleLastWeekdayOfMonth,
        private HandleMonthly $handleMonthly,
        private HandleWeekly $handleWeekly,
        private SetDateInEventData $setDateInEvent,
    ) { }

    public function gather($memberId, RapidCityTime $startDate, RapidCityTime $endDate): array
    {
        $tomorrow = (RapidCityTime::today())->addDays(1);
        if ($endDate->isBefore($tomorrow)) {
            return [];
        }
        $startOn = $startDate->isBefore($tomorrow) ? $tomorrow : $startDate->clone();
        $shipmentEvents = $this->getScheduledDates->getCalendarEvents($memberId, $startOn, $endDate);
        $events = [];
        foreach ($shipmentEvents as $shipmentEvent) {
            $events = array_merge($events, $this->handleShippingEvent($shipmentEvent, $startOn, $endDate));
        }
        $todaysDate = (RapidCityTime::today())->toDateString();
        unset($events[$todaysDate]);

        return array_values($events);
    }

    private function handleShippingEvent(ShippingEvent $shippingEvent, RapidCityTime $startDate, RapidCityTime $endDate): array
    {
        $recurrenceType = ucfirst((new CamelCase)($shippingEvent->getRecurrenceType()->getValue()));
        $handler = 'handle' . $recurrenceType;

        return $this->$handler->handle($shippingEvent, $startDate, $endDate);
    }
}
