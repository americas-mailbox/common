<?php
declare(strict_types=1);

namespace AMB\Interactor\Log;

use App\Message;
use AMB\Entity\Log\Activity;
use AMB\Interactor\RapidCityTime;

final class CreateActivityFromMessage
{
    public function create(Message $message): Activity
    {
        return (new Activity())
            ->setDate(new RapidCityTime())
            ->setPmb($message->getPmb())
            ->setTarget($message->getTarget());
    }
}
