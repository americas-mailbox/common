<?php
declare(strict_types=1);

namespace AMB\Cli\Communication;

use AMB\Entity\Member;
use AMB\Entity\Shipping\Carrier;
use AMB\Entity\Shipping\Delivery;
use AMB\Entity\Shipping\DeliveryCharges;
use AMB\Entity\Shipping\Shipment;
use IamPersistent\SimpleShop\Entity\CreditCard;
use Money\Currency;
use Money\Money;
use Symfony\Component\Console\Command\Command;

abstract class TestCommunicationCommand extends Command
{
    protected function getMoney($amount = 10000): Money
    {
        return new Money((string)$amount, new Currency('USD'));
    }

    protected function getDeliveryCharges(): DeliveryCharges
    {
        return (new DeliveryCharges())
            ->setTotal($this->getMoney());
    }

    protected function getCarrier($name = 'FedEx'): Carrier
    {
        return (new Carrier())
            ->setName($name);
    }

    protected function getCreditCard(): CreditCard
    {
        return (new CreditCard())
            ->setBrand('Visa')
            ->setCardNumber('4242424242424242');
    }

    protected function getDelivery(): Delivery
    {
        return (new Delivery())
            ->setCarrier($this->getCarrier())
            ->setCharges($this->getDeliveryCharges())
            ->setTrackingNumber('449044304137821');
    }

    protected function getMember(): Member
    {
        return (new Member())
            ->setId(113755)
            ->setPMB("1024");
    }

    protected function getShipment(): Shipment
    {
        return (new Shipment())
            ->setDelivery($this->getDelivery())
            ->setMember($this->getMember());
    }
}
