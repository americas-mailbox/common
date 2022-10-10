<?php
declare(strict_types=1);

namespace AMB\Cli\Communication;

use AMB\Communication\Member\IncomingDigitalMailCommunication;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

final class SendTestIncomingDigitalMailCommand extends TestCommunicationCommand
{
    protected static $defaultName = 'communication:send-test-incoming-digital-mail';

    public function __construct(
        private IncomingDigitalMailCommunication $communication,
    )  {
        parent::__construct();
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $this->communication->dispatch($this->getMember('8703'));
//        $this->communication->dispatch($this->getMember());

        return Command::SUCCESS;
    }
}
