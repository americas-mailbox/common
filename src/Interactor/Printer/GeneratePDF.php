<?php
declare(strict_types=1);

namespace AMB\Interactor\Printer;

use Knp\Snappy\Pdf;
use Twig\Environment;
use Twig\Loader\FilesystemLoader;

final class GeneratePDF
{
    /** @var \Twig\Environment */
    private $twig;
    /** @var string */
    private $wkhtmltopdf;

    public function __construct(Environment $twig, $wkhtmltopdf)
    {
        $this->twig = $twig;
        $this->wkhtmltopdf = $wkhtmltopdf;
    }

    public function generate($template, $filename, $data, $options)
    {
        $html = $this->twig->render($template, $data);
        $snappy = new Pdf($this->wkhtmltopdf);
        $snappy->setTimeout(null);
        $snappy->generateFromHtml($html, $filename, $options, true);
    }
}
