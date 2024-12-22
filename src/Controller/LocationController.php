<?php

namespace App\Controller;

use App\Repository\VideoRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;
use App\Entity\Video;
use App\Form\VideoType;
use Doctrine\ORM\EntityManagerInterface;



class LocationController extends AbstractController
{

    //  Exemple :
    // #[Route('/location', name: 'location.index')]
    // public function index(Request $request): Response
    // {
    //     return $this->render('location/index.html.twig', [
    //         'controller_name' => 'LocationController',
    //     ]);
    // }


    //Browse all videos with pagination
    #[Route('/Voyage', name: 'location.index')]
    public function index(Request $request, VideoRepository $repository): Response
    {
        //Paginator
        $page = $request->query->getInt('page', 1);
        $videos = $repository->paginateVideos($page);

       // Browse each video and capitalise the first letter of the title (slug)
        foreach ($videos as $video) {
            $video->setSlug(ucwords($video->getSlug()));
            $video->setSubtitle(ucwords($video->getSubtitle()));
        }

        return $this->render('location/index.html.twig', [
            'Videos' => $videos,
        ]);
    } 



    // //Browse all videos without pagination
    // #[Route('/Voyage', name: 'location.index')]
    // public function index(Request $request, VideoRepository $repository): Response
    // {
    //     $videos = $repository->findAll();

    //    // Browse each video and capitalise the first letter of the title (slug)
    //     foreach ($videos as $video) {
    //         $video->setSlug(ucwords($video->getSlug()));
    //     }

    //     return $this->render('location/index.html.twig', [
    //         'Videos' => $videos,
    //     ]);
    // } 



    //Browse all videos of WEST COAST USA
    #[Route('/Voyage/Cote-Ouest', name: 'location.west.index')]
    public function voyageWestCoast(Request $request, VideoRepository $repository): Response
    {

        // States filter
        $states = ['california', 'utah', 'nevada', 'arizona'];

        $videos = $repository->findByStates($states);

        //Paginator
        $page = $request->query->getInt('page', 1);
        $videos = $repository->paginateVideos($page, $states);

       // Browse each video and capitalise the first letter of the title (slug)
        foreach ($videos as $video) {
            $video->setSlug(ucwords($video->getSlug()));
        }

        return $this->render('location/west.html.twig', [
            'Videos' => $videos,
        ]);
    } 

    //Browse all videos of FLORIDA
    #[Route('/Voyage/Floride', name: 'location.florida.index')]
    public function voyageFlorida(Request $request, VideoRepository $repository): Response
    {

        // States filter
        $states = ['florida'];

        $videos = $repository->findByStates($states);

        //Paginator
        $page = $request->query->getInt('page', 1);
        $videos = $repository->paginateVideos($page, $states);

       // Browse each video and capitalise the first letter of the title (slug)
        foreach ($videos as $video) {
            $video->setSlug(ucwords($video->getSlug()));
        }

        return $this->render('location/florida.html.twig', [
            'Videos' => $videos,
        ]);
    } 


        
    //Show a video by id (and slug)
    #[Route('/Voyage/{slug}-{id}', name: 'location.showId', requirements: ['id' => '\d+','slug' => '[a-zA-Z0-9- ]*'])]
    public function showOne(Request $request, string $slug, int $id, VideoRepository $repository): Response
    {
    
        $video = $repository->find($id);

        if (!$video) {
            throw $this->createNotFoundException('Vidéo non trouvée.');
        }

        //Replace the space in the slug by a " - " to avoid the url to be displayed as " %20 " and capitalise the first letter of each word
        $formattedSlug = ucwords(str_replace(' ', '-', $video->getSlug()));
    
        // If slug is not equal to formatted slug, redirection to correct URL : permanently (301)
        if ($slug !== $formattedSlug) {
            return $this->redirectToRoute('location.showId', [
                'slug' => $formattedSlug,
                'id' => $id
            ], 301);  //Permanent redirection for navigator URL (code 301)
        }


        //Capitalise the first letter of each word in the subtitle and state
        $video->setSubtitle(ucwords($video->getSubtitle()));
        $video->setState(ucwords($video->getState()));
        $video->setSlug(ucwords($video->getSlug()));

        // TODO : 
        // if ($video->getSlug() !== $slug) {
        //     return $this->redirectToRoute('location.showId', ['slug' => $video->getSlug(), 'id' => $video->getId()]);
        // }
        return $this->render('location/show.html.twig', [
            'controller_name' => 'LocationController',
            'Video' => $video,
        ]);
    }




    // In the navbar when a word is searched : find all videos with the searchTerm in GET
     #[Route('/Voyage/Recherche', name: 'location.searchTerm', methods : ['GET'])]
    public function search(Request $request, VideoRepository $repository): Response
    {
        $searchTerm = $request->query->get('searchTerm');

        $videos = $repository->findVideoBysearchTerm($searchTerm);

          //Foreach videos : capitalise the first letter of each word in the subtitle and in state
        foreach ($videos as $video) {
            $video->setSlug(ucwords($video->getSlug()));
        }

        return $this->render('location/searchTerm.html.twig', [
            'Videos' => $videos,
            'searchTerm' => $searchTerm,
        ]);
    }



    //Create a new video in database
    #[Route('/Admin/Creer', name: 'location.create', methods : ['GET', 'POST'])]
    public function createNewVideo(Request $request, EntityManagerInterface $em): Response
    {

        //Need to be connected and have an admin-role for access
        $this->denyAccessUnlessGranted('ROLE_ADMIN');

        $newVideo = new Video();
        $form = $this->createForm(VideoType::class, $newVideo);
        $form->handleRequest($request);

            //If form is submitted and valid : redirection to home page with success message flashes (template/partials/flash.html.twig)
            if ($form->isSubmitted() && $form->isValid()) {


                    // Catch the value of the ‘duration’ field in the form submitted ex :'1.30'
                    $durationString = $form->get('duration')->getData();
                    // Convert format like 'm:ss' into secondes
                    list($minutes, $seconds) = explode('.', $durationString);
                    $totalSeconds = ($minutes * 60) + $seconds;
                    //Enter the duration in the database
                    $newVideo->setDuration($totalSeconds);


                $em->persist($newVideo);
                $em->flush();
                $this->addFlash('success', 'Et voilà une nouvelle vidéo en ligne !');
                return $this->redirectToRoute('location.index');
            }
            
            //If form is not submitted or invalid : redirection to edit page with error message flashes (template/partials/flash.html.twig)
            if ($form->isSubmitted() && !$form->isValid()) {
                $this->addFlash('error', 'Une erreur est survenue lors de la création de la vidéo. Veuillez vérifier les champs.');
            }

        return $this->render('location/create.html.twig', [
            'form' => $form,
        ]);
    }

    
    //Update a video in database
    #[Route('/Admin/{id}/Modifier', name: 'location.edit', methods : ['GET', 'POST'], requirements: ['id' => '\d+'])]
     public function editById(Video $video, Request $request, EntityManagerInterface $em): Response
    {

        //Need to be connected and have an admin-role for access
        $this->denyAccessUnlessGranted('ROLE_ADMIN');

            $form = $this->createForm(VideoType::class, $video);
            $form->handleRequest($request);

                //If form is submitted and valid : redirection to home page with success message flashes (template/partials/flash.html.twig)
                if ($form->isSubmitted() && $form->isValid()) {
                    
                     $em->flush();
                    $this->addFlash('success', 'Votre video a bien été modifiée');
                    return $this->redirectToRoute('home.adminPage');
                }
                    
                //If form is not submitted or invalid : redirection to edit page with error message flashes (template/partials/flash.html.twig)
                if ($form->isSubmitted() && !$form->isValid()) {
                    $this->addFlash('error', 'Une erreur est survenue lors de la modification de la vidéo. Veuillez vérifier les champs.');
                }

                return $this->render('location/edit.html.twig', [
                    'video' => $video,
                    'form' => $form,
                ]);
    }


    //Delete a video in database
    #[Route('/Admin/{id}', name: 'location.delete', methods: ['DELETE'], requirements: ['id' => '\d+'])]
     public function delete(Video $video, EntityManagerInterface $em): Response
    {

        //Need to be connected and have an admin-role for access
        $this->denyAccessUnlessGranted('ROLE_ADMIN');

        $em->remove($video);
        $em->flush();
        $this->addFlash('success', 'La video a bien été supprimée');
        return $this->redirectToRoute('location.index');
    }
}
 
