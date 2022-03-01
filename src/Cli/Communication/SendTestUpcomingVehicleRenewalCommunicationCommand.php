<?php
declare(strict_types=1);

namespace AMB\Cli\Communication;

use AMB\Communication\Member\UpcomingVehicleRenewalCommunication;
use AMB\Interactor\Member\FindMemberByPmb;
use AMB\Interactor\RapidCityTime;
use AMB\Interactor\View\PostCardsSelection;
use Doctrine\DBAL\Connection;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

final class SendTestUpcomingVehicleRenewalCommunicationCommand extends TestCommunicationCommand
{
    protected static $defaultName = 'communication:send-test-upcoming-vehicle-renewal';

    public function __construct(
        private FindMemberByPmb $findMemberByPmb,
        private UpcomingVehicleRenewalCommunication $communication,
    )  {
        parent::__construct();
    }

    protected function configure()
    {
        $this
            ->addArgument('pmb', InputArgument::REQUIRED);
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $pmb = $input->getArgument('pmb');
        $member = $this->findMemberByPmb->find($pmb);
        $postcards = $this->getPostcards();
        $this->communication->dispatch($member, $postcards);

        return Command::SUCCESS;
    }

    private function getPostcards(): array
    {
        $json = '{"15959":[{"postcard_id":"15959","expire_on":"2022-03-31","have_unapproved":false,"pmb":"15131","state":"SUCCESS","fee":{"title":"210280935","year":"2019","color":"WHI","make":"CHEV","fee":"$154.00","mail_fee":"$1.00","approved":"1"}},{"postcard_id":"15959","expire_on":"2022-03-31","have_unapproved":false,"pmb":"15131","state":"SUCCESS","fee":{"title":"210280939","year":"2019","color":"WHI","make":"CHEV","fee":"$154.00","mail_fee":"$1.00","approved":"1"}},{"postcard_id":"15959","expire_on":"2022-03-31","have_unapproved":false,"pmb":"15131","state":"SUCCESS","fee":{"title":"210280952","year":"2020","color":"BLK","make":"CHEV","fee":"$154.00","mail_fee":"$1.00","approved":"1"}},{"postcard_id":"15959","expire_on":"2022-03-31","have_unapproved":false,"pmb":"15131","state":"SUCCESS","fee":{"title":"211901519","year":"2021","color":"WHI","make":"CHEV","fee":"$154.00","mail_fee":"$1.00","approved":"1"}},{"postcard_id":"15959","expire_on":"2022-03-31","have_unapproved":false,"pmb":"15131","state":"SUCCESS","fee":{"title":"211901565","year":"2021","color":"WHI","make":"CHEV","fee":"$154.00","mail_fee":"$1.00","approved":"1"}},{"postcard_id":"15959","expire_on":"2022-03-31","have_unapproved":false,"pmb":"15131","state":"SUCCESS","fee":{"title":"211901582","year":"2021","color":"WHI","make":"CHEV","fee":"$154.00","mail_fee":"$1.00","approved":"1"}}]}';

        return json_decode($json, true);
    }
}
