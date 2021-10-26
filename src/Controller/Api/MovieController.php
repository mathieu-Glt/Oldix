<?php

namespace App\Controller\Api;

use App\Repository\MovieRepository;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

/**
 * @Route("/api/movies", name="api_movies_")
 */
class MovieController extends AbstractController
{
    /**
     * 
     * @Route("/research", name="research", methods={"GET"})
     * @param MovieRepository $movieRepository
     * @param Request $request
     * @return Response
     */
    public function research(MovieRepository $movieRepository, Request $request): Response
    {
        $query = $request->query->get('q');
        if (!$query) {
            return $this->json([
                'message' => 'You must add a query content',
                'errorCode' => '400'
            ], 400);
        }
        $queryResult = $movieRepository->findByQuery($query);
        if (empty($queryResult)) {
            return $this->json([
                'message' => 'This query has no results.',
                'errorCode' => '404'
            ], 404);
        }

        return $this->json($queryResult, 200, [], ['groups' => 'movies_search']);
    }

    /**
     * 
     * @Route("/random", name="random", methods={"GET"})
     * @param MovieRepository $movieRepository
     * @return Response
     */
    public function random(MovieRepository $movieRepository): Response
    {
        $allMovies = $movieRepository->findAll();
        $randomKey = array_rand($allMovies, 1);
        $randomMovie = $allMovies[$randomKey];

        return $this->json($randomMovie, 200, [], ['groups' => 'movie_read']);

    }
    /**
     * 
     * @Route("/{slug}", name="read")
     * @param string $slug
     * @param MovieRepository $movieRepository
     * @return Response
     */
    public function read(string $slug, MovieRepository $movieRepository): Response
    {
        $movie = $movieRepository->findOneBySlug($slug);

        if (!$movie) {
            return $this->json([
                'message' => 'This movie does not exist',
                'errorCode' => '404'
            ], 404);
        }
        return $this->json($movie, 200, [], ['groups' => 'movie_read']);
    }
}
