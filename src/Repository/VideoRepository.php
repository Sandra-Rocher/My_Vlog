<?php

namespace App\Repository;

use App\Entity\Video;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Knp\Component\Pager\PaginatorInterface;
use Knp\Component\Pager\Pagination\PaginationInterface;

/**
 * @extends ServiceEntityRepository<Video>
 */
class VideoRepository extends ServiceEntityRepository
{
    //SR Constructor basic :
    // public function __construct(ManagerRegistry $registry)
    public function __construct(ManagerRegistry $registry, private PaginatorInterface $paginator)
    {
         parent::__construct($registry, Video::class);
    }

    //    /**
    //     * @return Video[] Returns an array of Video objects
    //     */
    //    public function findByExampleField($value): array
    //    {
    //        return $this->createQueryBuilder('v')
    //            ->andWhere('v.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->orderBy('v.id', 'ASC')
    //            ->setMaxResults(10)
    //            ->getQuery()
    //            ->getResult()
    //        ;
    //    }



        /**
         * @return Video[] Returns an array of Video objects when searchTerm is completed
         */
        //function find one or more videos by searchTerm in navbar
        public function findVideoBysearchTerm(string $searchTerm): array
        {
            return $this->createQueryBuilder('alias')
            //Case-sensitive, switches the searchTerm to LOWER case for the state, slug and subtitle
            ->where('LOWER(alias.subtitle) LIKE LOWER(:searchTerm)')
            ->orWhere('LOWER(alias.state) LIKE LOWER(:searchTerm)')
            ->orWhere('LOWER(alias.slug) LIKE LOWER(:searchTerm)') 
            ->orWhere('LOWER(alias.comm) LIKE LOWER(:searchTerm)')
            ->setParameter('searchTerm', '%' . $searchTerm . '%')
            ->orderBy('alias.id', 'ASC')
            ->getQuery()
            ->getResult();

        }


        /**
         * @return Video[] Returns an array of Video objects with all durations
         */
        //Function get total Durations of all videos
        public function getTotalDuration(): array
        {

            $videos = $this->findAll();

            $totalDurationInSeconds = 0;

            // SUM of all duration videos (stored in seconds in the database)
            foreach ($videos as $video) {
                $totalDurationInSeconds += $video->getDuration();
            }

            // Convert total time into hours, minutes and seconds
            $hours = floor($totalDurationInSeconds / 3600);
            $minutes = floor(($totalDurationInSeconds % 3600) / 60);
            $seconds = $totalDurationInSeconds % 60;

            return [
                'hours' => $hours,
                'minutes' => $minutes,
                'seconds' => $seconds,
            ];
        }


        //Function to filter videos by states
        public function findByStates(array $states)
        {
            return $this->createQueryBuilder('v')
                ->andWhere('v.state IN (:states)')
                ->setParameter('states', $states)
                ->getQuery()
                ->getResult();
        }

        
        //KNP Paginator basic without states
        //  public function paginateVideos(int $page): PaginationInterface
        //  {
        //         return $this->paginator->paginate(
        //             $this->createQueryBuilder('v'),
        //             $page, 
        //             9
        //         );
        //  }


        //KNP Paginator with or without states parameters
        public function paginateVideos(int $page, ?array $state = null): PaginationInterface
        {
            //For pagination with state (if it's west or florida) or without state (for all videos)
            $queryBuilder = $this->createQueryBuilder('v');

            if ($state) {
                $queryBuilder->where('v.state IN (:state)')
                    ->setParameter('state', $state);
                }

            return $this->paginator->paginate(
                $queryBuilder,
                $page,
                6 // number of videos per page
            );
        }

        

}




