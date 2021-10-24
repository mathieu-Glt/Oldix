<?php

namespace App\Controller\Api;

use App\Repository\MovieRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

/**
 * @Route("/api/movies")
 */
class MovieController extends AbstractController
{
    /**
     * 
     * @Route("/research", name="api_movie_research", methods={"GET"})
     * @param MovieRepository $movieRepository
     * @param Request $request
     * @return Response
     */
    public function research(MovieRepository $movieRepository, Request $request): Response
    {
        $query = $request->query->get('q');
        if (!$query) {
            return $this->json([], 400);
        }
        $queryResult = $movieRepository->findByQuery($query);
        if (empty($queryResult)) {
            return $this->json([], 404);
        }

        return $this->json($queryResult, 200, [], ['groups' => 'movies_search']);
    }

    /**
     * 
     * @Route("/random", name="api_movies_random", methods={"GET"})
     * @param MovieRepository $movieRepository
     * @return Response
     */
    public function random(MovieRepository $movieRepository): Response
    {
        $allMovies = $movieRepository->findAll();

        $randomKey = array_rand($allMovies, 1);
        $randomMovie = $allMovies[$randomKey];

        return $this->json($randomMovie, 200);
    }

    /**
     * 
     * @Route("/{slug}", name="movie_read")
     * @param string $slug
     * @param MovieRepository $movieRepository
     * @return Response
     */
    public function read(string $slug, MovieRepository $movieRepository): Response
    {
        $movie = $movieRepository->findOneBySlug($slug);

        if (!$movie) {
            return $this->json([], 404);
        }
        return $this->json($movie, 200, [], ['groups' => 'movie_read']);
    }
}
