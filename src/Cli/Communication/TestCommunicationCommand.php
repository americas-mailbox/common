<?php
declare(strict_types=1);

namespace AMB\Cli\Communication;

use AMB\Entity\Member;
use AMB\Entity\Member\Plan as MemberPlan;
use AMB\Entity\Plan;
use AMB\Entity\RenewalFrequency;
use AMB\Entity\Shipping\Carrier;
use AMB\Entity\Shipping\Delivery;
use AMB\Entity\Shipping\DeliveryCharges;
use AMB\Entity\Shipping\Shipment;
use OLPS\SimpleShop\Entity\CreditCard;
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

    protected function getMember($pmb = '1024'): Member
    {
        if ($pmb === '8703') {
            return (new Member())
                ->setEmail('josephmanqueros@gmail.com')
                ->setFirstName('Joseph')
                ->setId(107592)
                ->setLastName('Manqueros')
                ->setPhone('')
                ->setMemberPlan($this->getMemberPlan())
                ->setPMB("8703");
        }
        return (new Member())
            ->setEmail('shank.amb.emails@gmail.com')
            ->setFirstName('Rich')
            ->setId(113755)
            ->setLastName('Shank')
            ->setPhone('(828) 275-8052')
            ->setMemberPlan($this->getMemberPlan())
            ->setPMB("1024");
    }

    protected function getMemberPlan(string $plan = 'Gold'): MemberPlan
    {
        return (new MemberPlan())
            ->setRenewalFrequency(RenewalFrequency::ANNUAL())
            ->setPlan($this->getPlan($plan));
    }

    protected function getPlan(string $plan = 'Gold'): Plan
    {
        return (new Plan())
            ->setGroup(strtoupper($plan))
            ->setRenewalFrequency(RenewalFrequency::ANNUAL())
            ->setTitle($plan);
    }

    protected function getShipment(): Shipment
    {
        return (new Shipment())
            ->setDelivery($this->getDelivery())
            ->setMember($this->getMember());
    }
}
