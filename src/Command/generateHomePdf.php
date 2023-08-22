<?php

namespace App\Command;

use Knp\Snappy\Pdf;
use Twig\Environment;

class generateHomePdf
{
    private Environment $twig;
    private Pdf $pdf;

    public function __construct(Environment $twig, Pdf $pdf)
    {
        $this->twig = $twig;
        $this->pdf = $pdf;
    }

    public function generatePdf(): void
    {
        $html = $this->twig->render('Front/TestsWK/home.html.twig');
        $this->pdf->setOption('enable-local-file-access', true);
        $pdf = $this->pdf->getOutputFromHtml($html);

    }
}