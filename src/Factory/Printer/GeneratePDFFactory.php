<?php
declare(strict_types=1);

namespace AMB\Factory\Printer;

use AMB\Interactor\Printer\GeneratePDF;
use Psr\Container\ContainerInterface;
use Twig\Environment;
use Xaddax\Interactor\GatherConfigValues;

final class GeneratePDFFactory
{
    public function __invoke(ContainerInterface $container): GeneratePDF
    {
        $wkhtmltopdf = getenv('WKHTMLTOPDF');
        $twig = $container->get(Environment::class);

        return new GeneratePDF($twig, $wkhtmltopdf);
    }
}
