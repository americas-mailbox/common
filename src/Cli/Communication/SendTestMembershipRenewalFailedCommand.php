<?php
declare(strict_types=1);

namespace AMB\Cli\Communication;

use AMB\Communication\Member\MembershipRenewalFailedCommunication;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

final class SendTestMembershipRenewalFailedCommand extends TestCommunicationCommand
{
    protected static $defaultName = 'communication:send-test-membership-renewal-failed';

    public function __construct(
        private MembershipRenewalFailedCommunication $communication,
    )  {
        parent::__construct();
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $this->communication->dispatch($this->getMember(), $this->getMoney(), $this->getCreditCard(), 'this is a test');

        return Command::SUCCESS;
    }
}
