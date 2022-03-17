<?php
declare(strict_types=1);

namespace AMB\View\ShippingEvent\Handler;

use AMB\Entity\Shipping\ShippingEvent;
use AMB\Interactor\OfficeClosure\IsOfficeClosed;
use AMB\Interactor\RapidCityTime;
use Doctrine\DBAL\Connection;

final class SetDateInEventData
{
    /** @var string */
    private $offset;
    private $membershipId;

    public function __construct(
        private Connection $connection,
        private IsOfficeClosed $isOfficeClosed,
    ) { }

    public function set(ShippingEvent $event, array &$data, RapidCityTime $eventDate): string
    {
        $this->membershipId = $event->getMember()->getId();

        $data['startDate'] = $eventDate->toDateString();

        if ($this->isOfficeClosed->on($eventDate)) {
            $eventDate = $this->getOffsetDate($eventDate);
        }

        $date = $eventDate->toDateString();
        $data['date'] = $date;
        $id = $event->getId() . '-' . $date;
        $data['id'] = $id;

        $data['inThePast'] = $eventDate->lte(RapidCityTime::endOfToday());

        return $date;
    }

    private function getAfterOffsetDate(RapidCityTime $date): RapidCityTime
    {
        do {
            $date->addDay();
        } while ($this->isOfficeClosed->on($date));

        return $date;
    }

    private function getBeforeOffsetDate(RapidCityTime $date): RapidCityTime
    {
        do {
            $date->subDay();
        } while ($this->isOfficeClosed->on($date));

        return $date;
    }

    private function getOffset(): string
    {
        if (empty($this->offset)) {
            $this->setOffset();
        }

        return $this->offset;
    }

    private function getOffsetDate(RapidCityTime $date): RapidCityTime
    {
        $date = $date->clone();
        if ('before' === $this->getOffset()) {
            return $this->getBeforeOffsetDate($date);
        }

        return $this->getAfterOffsetDate($date);
    }

    private function setOffset()
    {
        $sql = <<<SQL
SELECT office_closed_delivery 
FROM accounts
JOIN members ON members.account_id = accounts.id
WHERE member_id = $this->membershipId;
SQL;

        $this->offset = $this->connection->fetchOne($sql);
    }
}
