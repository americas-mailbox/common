<?php
declare(strict_types=1);

namespace AMB;

use AMB\Factory\Printer\GeneratePDFFactory;
use AMB\Factory\TwigEnvironmentFactory;
use AMB\Interactor\Printer\GeneratePDF;
use Twig\Environment;

final class ConfigProvider
{
    public function __invoke(): array
    {
        return [
            'dependencies' => $this->getDependencies(),
        ];
    }

    private function getDependencies(): array
    {
        return [
            'factories' => [
                Environment::class => TwigEnvironmentFactory::class,
                GeneratePDF::class => GeneratePDFFactory::class,
            ],
        ];
    }
}
