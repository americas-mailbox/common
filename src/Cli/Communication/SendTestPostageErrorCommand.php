<?php
declare(strict_types=1);

namespace AMB\Cli\Communication;

use AMB\Communication\Admin\PostageErrorCommunication;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

final class SendTestPostageErrorCommand extends TestCommunicationCommand
{
    protected static $defaultName = 'communication:send-test-postage-error';

    public function __construct(
        private PostageErrorCommunication $communication,
    )  {
        parent::__construct();
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $this->communication->dispatch($this->getShipment(), $this->getMoney());

        return Command::SUCCESS;
    }
}
