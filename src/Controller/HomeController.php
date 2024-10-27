<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
//For duration videos we need :
use App\Repository\VideoRepository;
use Doctrine\ORM\EntityManager;
//for Admin page we need :
// use App\Controller\Request;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use App\Entity\User;
//use App\Controller\EntityManagerInterface;
use Doctrine\ORM\EntityManagerInterface;
// use App\Pagination\PaginatorInterface;
use Knp\Component\Pager\PaginatorInterface;

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


    //Route home index with duration
    #[Route('/home', name: 'home')]
    public function index(VideoRepository $repository): Response
    {
        //With getTotalDuration function in videorepository :
        $totalDuration = $repository->getTotalDuration();

        return $this->render('home/index.html.twig', [
            'controller_name' => 'HomeController',
            'hours' => $totalDuration['hours'],
            'minutes' => $totalDuration['minutes'],
            'seconds' => $totalDuration['seconds'],
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
}
