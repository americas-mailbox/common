<?php
declare(strict_types=1);

namespace AMB\Factory\Printer;

use Psr\Container\ContainerInterface;
use Twig\Environment;
use Twig\Loader\FilesystemLoader;
use Xaddax\Interactor\GatherConfigValues;

final class TwigEnvironmentFactory
{
    public function __invoke(ContainerInterface $container): Environment
    {
        $config = (new GatherConfigValues)($container, 'templates');
        $twigOptions = [
            'autoescape' => false,
        ];
        $loader = new FilesystemLoader($config['paths']);

        return new Environment($loader, $twigOptions);
    }
}
