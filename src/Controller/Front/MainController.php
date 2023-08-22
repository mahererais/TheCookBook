<?php

namespace App\Controller\Front;

use Knp\Snappy\Pdf;
use Twig\Environment;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Knp\Bundle\SnappyBundle\Snappy\Response\PdfResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class MainController extends AbstractController
{
    /**
     * @Route("/", name="tcb_front_main_home")
     */
    public function index(): Response
    {
        return $this->render('Front/home/index.html.twig', [
            'controller_name' => 'MainController',
        ]);
    }

    /**
     * @Route("/pdf", name="tcb_front_main_pdf")
     */

    public function pdfAction(Pdf $knpSnappyPdf)
    {
        $html = $this->renderView('Front/TestsWK/home.html.twig', array());
        $knpSnappyPdf->setOption('enable-local-file-access', true);

        return new PdfResponse(
            $knpSnappyPdf->getOutputFromHtml($html),
            'file.pdf'
        );
    }
}
