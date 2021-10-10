<?php
declare(strict_types=1);

namespace AMB\Cli\Communication;

use AMB\Communication\Member\MembershipRenewedCommunication;
use IamPersistent\SimpleShop\Entity\Invoice;
use IamPersistent\SimpleShop\Entity\Paid;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

final class SendTestMembershipRenewedCommand extends TestCommunicationCommand
{
    protected static $defaultName = 'communication:send-test-membership-renewed';

    public function __construct(
        private MembershipRenewedCommunication $communication,
    )  {
        parent::__construct();
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $paid = (new Paid())
            ->setPaymentMethod($this->getCreditCard());
        $invoice = (new Invoice())
            ->setPaid($paid)
            ->setTotal($this->getMoney());

        $this->communication->dispatch($this->getMember(), $invoice);

        return Command::SUCCESS;
    }
}
