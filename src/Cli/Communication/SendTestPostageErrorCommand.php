<?php
declare(strict_types=1);

namespace AMB\Cli\Communication;

use AMB\Communication\Admin\PostageErrorCommunication;
use AMB\Entity\Member;
use AMB\Entity\Shipping\Carrier;
use AMB\Entity\Shipping\Delivery;
use AMB\Entity\Shipping\DeliveryCharges;
use AMB\Entity\Shipping\Shipment;
use Money\Currency;
use Money\Money;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

final class SendTestPostageErrorCommand extends Command
{
    protected static $defaultName = 'communication:send-test-postage-error';

    public function __construct(
        private PostageErrorCommunication $communication,
    )  {
        parent::__construct();
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $totalCharge = new Money('10000', new Currency('USD'));
        $charges = (new DeliveryCharges())
            ->setTotal($totalCharge);
        $carrier = (new Carrier())
            ->setName('FedEx');

        $delivery = (new Delivery())
            ->setCarrier($carrier)
            ->setCharges($charges);

        $member = (new Member())
            ->setId(113755)
            ->setPMB("1024");

        $shipment = (new Shipment())
            ->setDelivery($delivery)
            ->setMember($member);

        $this->communication->dispatch($shipment, $totalCharge);

        return Command::SUCCESS;
    }
}
