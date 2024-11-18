<?php 

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use App\Repository\VideoRepository;
use App\Service\PdfGeneratorService;

class PdfController extends AbstractController
{

    //Show a PDF with ID
    #[Route('/view-pdf/{id}', name: 'app_view_pdf')]
    public function viewPdf(int $id, VideoRepository $videoRepository, PdfGeneratorService $pdfGeneratorService): Response
    {
        $video = $videoRepository->find($id);
        if (!$video) {
            throw $this->createNotFoundException('Vidéo non trouvée.');
        }

        $html = $this->renderView('pdf/viewPdf.html.twig', [
            'Video' => $video,
        ]);

        $pdfContent = $pdfGeneratorService->getPdf($html);

        return new Response($pdfContent, 200, [
            'Content-Type' => 'application/pdf',
            'Content-Disposition' => 'inline; filename="' . $video->getSlug() . '.pdf"',
         ]);
    }



    //Download a PDF with ID
    #[Route('/download-pdf/{id}', name: 'app_download_pdf')]
    public function downloadPdf(int $id, VideoRepository $videoRepository, PdfGeneratorService $pdfGeneratorService): Response
    {
        $video = $videoRepository->find($id);
        if (!$video) {
            throw $this->createNotFoundException('Vidéo non trouvée.');
        }

        $html = $this->renderView('pdf/downloadPdf.html.twig', [
            'Video' => $video,
        ]);

        $pdfContent = $pdfGeneratorService->getPdf($html);

        return new Response($pdfContent, 200, [
            'Content-Type' => 'application/pdf',
            'Content-Disposition' => 'attachment; filename="' . $video->getSlug() . '.pdf"',
        ]);
    }

    
    //Test for Show a simply PDF
    // #[Route('/output-pdf', name: 'app_output_pdf')]
    //     public function output(PdfGeneratorService $pdfGeneratorService): Response
    //     {
            
    //         // $html = "<h1>Hello World</h1><p>This is a PDF document.</p>";
    //         $html = $this->renderView('pdf/viewPdf.html.twig');
    //         $content = $pdfGeneratorService->getPdf($html);

    //         return new Response($content, 200, [
    //             'Content-Type' => 'application/pdf',
    //             // 'Content-Disposition' => 'inline; filename="output.pdf"',
    //         ]);
    //     }


    //Test for Download a simply PDF
    // #[Route('/stream-pdf', name: 'app_stream_pdf')]
    //     public function streamPdf(PdfGeneratorService $pdfGeneratorService): Response
    //     {
    //         // $html = "<h1>Hello World</h1><p>This is a downloadable PDF document.</p>";
    //         $html = $this->renderView('pdf/downloadPdf.html.twig');
    //         $filename = 'download.pdf';
    //         return $pdfGeneratorService->getStreamResponse($html, $filename);
    //     }
}
