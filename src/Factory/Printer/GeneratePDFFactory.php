<?php
declare(strict_types=1);

namespace AMB\Factory\Printer;

use AMB\Interactor\Printer\GeneratePDF;
use Psr\Container\ContainerInterface;
use Xaddax\Interactor\GatherConfigValues;

final class GeneratePDFFactory
{
    public function __invoke(ContainerInterface $container): GeneratePDF
    {
        $wkhtmltopdf = getenv('WKHTMLTOPDF');
        $config = (new GatherConfigValues)($container, 'print');

        return new GeneratePDF($config['templateDirectories'], $wkhtmltopdf);
    }
}
