<?php
declare(strict_types=1);

namespace AMB\Cli\Communication;

use AMB\Communications\Member\MemberSuspensionReminderCommunication;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

final class SendTestMembershipSuspensionReminderCommand extends TestCommunicationCommand
{
    protected static $defaultName = 'communication:send-test-membership-suspension-reminder';

    public function __construct(
        private MemberSuspensionReminderCommunication $communication,
    )  {
        parent::__construct();
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $this->communication->dispatch($this->getMember(), 'this is a test');

        return Command::SUCCESS;
    }
}
