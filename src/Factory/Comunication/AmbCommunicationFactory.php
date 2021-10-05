<?php
declare(strict_types=1);

namespace AMB\Factory\Communication;

use AMB\Communication\AmbCommunication;
use AMB\Interactor\Communication\CommunicationTemplateHandler;
use Communication\Factory\CommunicationFactory;
use Laminas\ServiceManager\Factory\AbstractFactoryInterface;
use Psr\Container\ContainerInterface;
use Symfony\Component\Notifier\NotifierInterface;

class AmbCommunicationFactory extends CommunicationFactory implements AbstractFactoryInterface
{
    public function canCreate(ContainerInterface $container, $requestedName)
    {
        return (is_a($requestedName, AmbCommunication::class, true));
    }

    public function __invoke($container, $requestedName, array $options = null)
    {
        $config = $container->get('config')['communication'];
        $communicationFactories = $this->getCommunicationFactories($container, $config['channel']);
        $context = $this->getContext($container, $config['context']);
        $notifier = $container->get(NotifierInterface::class);
        $templateHandler = $container->get(CommunicationTemplateHandler::class);

        return new $requestedName($context, $communicationFactories, $notifier, $templateHandler);
    }
}

