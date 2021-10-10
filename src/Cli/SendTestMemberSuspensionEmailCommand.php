<?php
declare(strict_types=1);

namespace AMB\Cli;

use AMB\Cli\Communication\TestCommunicationCommand;
use AMB\Entity\Member;
use App\Factory\Event\NotifyOfMemberSuspensionEventFactory;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

final class SendTestMemberSuspensionEmailCommand extends TestCommunicationCommand
{
    protected static $defaultName = 'send-test-member-suspension';

    public function __construct(
        private NotifyOfMemberSuspensionEventFactory $factory,
    ) {
        parent::__construct();
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $this->factory->dispatch($this->getMember(), 'For test purposes');

        return Command::SUCCESS;
    }
}
