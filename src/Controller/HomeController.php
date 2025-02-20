<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use App\Repository\VideoRepository;
use Symfony\Component\HttpFoundation\Request;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\BinaryFileResponse;


class HomeController extends AbstractController
{

    //Basic exemple :
    // #[Route('/Home', name: 'home')]
    // public function index(): Response
    // {
    //     return $this->render('home/index.html.twig', [
    //         'controller_name' => 'HomeController',
    //     ]);
    // }

    //Route home AND ROOT = SAME : index with duration
    #[Route('/', name: 'root')]
    #[Route('/home', name: 'home')]
    public function index(VideoRepository $repository): Response
    {
        //With getTotalDuration function in videorepository :
        $totalDuration = $repository->getTotalDuration();

        // Convert hours and minutes to integers to avoid problems such as type "string" (App\Entity\Video)
        $hours = (int) $totalDuration['hours'];
        $minutes = (int) $totalDuration['minutes'];
        $seconds = (int) $totalDuration['seconds'];
        
        // if necessary : add a 0 in front of the number
        $minutes = str_pad($minutes, 2, '0', STR_PAD_LEFT);
        $seconds = str_pad($seconds, 2, '0', STR_PAD_LEFT);

        return $this->render('home/index.html.twig', [
            'controller_name' => 'HomeController',
            'hours' => $hours,
            'minutes' => $minutes,
            'seconds' => $seconds,
     ]);
    }


     //Route for admin page without pagination 
    //  #[Route('/Admin', name: 'home.adminPage')]
    //  public function adminConnexion(Request $request, VideoRepository $repository): Response
    //  {

    //     //Need to be connected and have an admin-role for access
    //     $this->denyAccessUnlessGranted('ROLE_ADMIN');

    //     $videos = $repository->findAll();

    //     // Browse each video and capitalise the first letter of the title (slug)
    //     foreach ($videos as $video) {
    //         $video->setSlug(ucwords($video->getSlug()));
    //     }

    //      return $this->render('home/adminPage.html.twig', [
    //          'videos' => $videos,
    //      ]);
    //  }


    //Route for admin page with pagination sortable for sort ID and SLUG
     #[Route('/Admin', name: 'home.adminPage')]
    public function adminConnexion(Request $request, VideoRepository $repository, PaginatorInterface $paginator): Response
    {
        //Need to be connected and have an admin-role for access
        $this->denyAccessUnlessGranted('ROLE_ADMIN');

        // Find all videos
        $query = $repository->createQueryBuilder('v')->getQuery();

        // Oblige to do pagination for use knp_pagination_sortable
        $videos = $paginator->paginate(
            $query,
            $request->query->getInt('page', 1),
            100 // max videos to show on each page
        );

        // Browse each video and capitalise the first letter of the title (slug)
        foreach ($videos as $video) {
            $video->setSlug(ucwords($video->getSlug()));
        }

        return $this->render('home/adminPage.html.twig', [
            'videos' => $videos,
        ]);
    }



    //Route for recrut page
    #[Route('/Recruteur', name: 'home.recrut', methods : ['GET'])]
    public function recrut(): Response
    {
        return $this->render('home/recrut.html.twig', [
            'controller_name' => 'HomeController',
        ]);
    }


    //Route for mentions page
    #[Route('/Mentions-Legales', name: 'home.mentions', methods : ['GET'])]
    public function mention(): Response
    {
        return $this->render('home/mentions.html.twig', [
            'controller_name' => 'HomeController',
        ]);
    }


    //Route for show my CV in a PDF
    #[Route('/CV', name: 'app_cv')]
    public function showMyCV(): BinaryFileResponse
    {
        // My full CV :
        // $filePath = $this->getParameter('kernel.project_dir') . '/public/Footer/CV_Sandra_Rocher.pdf';
        // My CV special IT :
        $filePath = $this->getParameter('kernel.project_dir') . '/public/Footer/Sandra_Rocher_CV.pdf';

        if (!file_exists($filePath)) {
            throw $this->createNotFoundException("Le fichier CV n'existe pas.");
        }

        return new BinaryFileResponse($filePath);
    }


}

   

