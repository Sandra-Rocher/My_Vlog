<?php

namespace App\Service;

use Nucleos\DompdfBundle\Factory\DompdfFactoryInterface;
use Nucleos\DompdfBundle\Wrapper\DompdfWrapperInterface;
use Symfony\Component\HttpFoundation\StreamedResponse;
use App\Service\Response;


class PdfGeneratorService
{
    public function __construct(private Readonly DompdfFactoryInterface $factory, private Readonly DompdfWrapperInterface $wrapper)
    {

    }


    public function getPdf(string $html) : string
    {
        return $this->wrapper->getPdf($html);
    }


    public function getStreamResponse(string $html, string $filename): StreamedResponse
    {
        return $this->wrapper->getStreamResponse($html, $filename);
    }


    public function output(string $html) : string
    {
        $dompdf = $this->factory->create();
        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'landscape');
        $dompdf->render();
        return $dompdf->output();
    }

    


    // public function getStreamResponse(string $html, string $filename): StreamedResponse
    // {
    //     // Créez une instance de Dompdf
    //     $dompdf = $this->factory->create();

    //     // Activez l'option isRemoteEnabled pour charger les ressources distantes et locales
    //     $options = $dompdf->getOptions();
    //     $options->set('isRemoteEnabled', true); // Permet le chargement des ressources externes et locales
    //     $options->set('chroot', '%kernel.project_dir%/public'); // Définit le répertoire pour accéder aux images locales

    //     // Chargez le HTML dans Dompdf
    //     $dompdf->loadHtml($html);

    //     // Définir la taille et l'orientation du papier
    //     $dompdf->setPaper('A4', 'landscape');

    //     // Rendu du PDF
    //     $dompdf->render();

    //     // Diffuser le PDF en réponse
    //     return $this->wrapper->getStreamResponse($html, $filename); // Utilisation du wrapper pour envoyer la réponse
    // }


}
    

   

