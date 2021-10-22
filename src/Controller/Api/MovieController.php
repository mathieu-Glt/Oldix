<?php

namespace App\Controller\Api;

use App\Repository\MovieRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MovieController extends AbstractController
{
    /**
     * Get details of a film
     * 
     * @Route("api/"movies/{slug}", name="app_movie", methods={"GET"})
     * @param Movie $movie
     * @param MovieRepository $movieRepository
     * @return Response
     */
    public function read($slug, MovieRepository $movieRepository): Response
    {   
 
        $detailsMovie = $movieRepository->findByOneSlug($slug);
        
        if (!$detailsMovie) {
            return $this->json([], 404);
        } else {
            return $this->json($detailsMovie, 200);

        }
    
    }

    

}
