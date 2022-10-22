<?php
declare(strict_types=1);

namespace AMB\Interactor\ShippingEvent;

use AMB\Entity\Shipping\ShippingEvent;
use AMB\Interactor\Shipping\SaveShippingEvent;
use Carbon\Carbon;

final class EventChangeManager
{
    /** @var \AMB\Interactor\ShippingEvent\DeleteDateInRecurringEvent */
    private $deleteDateInRecurringEvent;
    /** @var \AMB\Interactor\ShippingEvent\DeleteOneTimeEvent */
    private $deleteOneTimeEvent;
    /** @var \AMB\Interactor\ShippingEvent\DeleteThisAndFollowingEvent */
    private $deleteThisAndFollowingEvent;

    public function __construct(
        private SaveShippingEvent $saveShippingEvent
    ) {
        $this->deleteDateInRecurringEvent = new DeleteDateInRecurringEvent($this->saveShippingEvent);
        $this->deleteOneTimeEvent = new DeleteOneTimeEvent($this->saveShippingEvent);
        $this->deleteThisAndFollowingEvent = new DeleteThisAndFollowingEvent($this->saveShippingEvent);
    }

    public function deleteDate(ShippingEvent $shippingEvent, Carbon $date)
    {
        if ($shippingEvent->isRecurring()) {
            $this->deleteDateInRecurringEvent->delete($shippingEvent, $date);
        } else {
            $this->deleteOneTimeEvent->delete($shippingEvent);
        }
    }

    public function deleteThisAndFollowing(ShippingEvent $shippingEvent, Carbon $date)
    {
        $this->deleteThisAndFollowingEvent->delete($shippingEvent, $date);
    }
}
