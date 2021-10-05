<?php
declare(strict_types=1);

namespace AMB\Factory\Communication;

use AMB\Interactor\Communication\GetMemberRecipientChannels;
use AMB\Interactor\Communication\CommunicationTemplateHandler;
use AMB\Communication\MemberCommunication;
use Symfony\Component\Notifier\NotifierInterface;

final class MemberCommunicationFactory extends AmbCommunicationFactory
{
    public function canCreate($container, $requestedName)
    {
        return (is_a($requestedName, MemberCommunication::class, true));
    }

    public function __invoke($container, $requestedName, array $options = null)
    {
        $config = $container->get('config')['communication'];
        $channels = $this->getChannels($requestedName, $config);
        $communicationFactories = $this->getCommunicationFactories($container, $config['channel']);
        $context = $this->getContext($container, $config['context']);
        $getMemberRecipientChannels = $container->get(GetMemberRecipientChannels::class);
        $notifier = $container->get(NotifierInterface::class);
        $templateHandler = $container->get(CommunicationTemplateHandler::class);

        return new $requestedName(
            $notifier,
            $context,
            $templateHandler,
            $getMemberRecipientChannels,
            $channels,
            $communicationFactories
        );
    }
}

