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
                'code' => Response::HTTP_BAD_REQUEST
            ], Response::HTTP_BAD_REQUEST);
        }
        $queryResult = $movieRepository->findByQuery($query);
        if (empty($queryResult)) {
            return $this->json([
                'message' => 'This query has no results.',
                'code' => Response::HTTP_NOT_FOUND
            ], Response::HTTP_NOT_FOUND);
        }

        return $this->json($queryResult, Response::HTTP_OK, [], ['groups' => 'movies_search']);
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

        return $this->json($randomMovie, Response::HTTP_OK, [], ['groups' => 'movie_read']);
    }
    /**
     * 
     * @Route("/{slug}", name="read", methods={"GET"}, requirements={"slug":"^[a-z0-9]+(?:-[a-z0-9]+)*$"})
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
                'code' => Response::HTTP_NOT_FOUND
            ], Response::HTTP_NOT_FOUND);
        }
        return $this->json($movie, Response::HTTP_OK, [], ['groups' => 'movie_read']);
    }

    /**
     * Return a collection of 3 movies from Hitchcock
     * 
     * @Route("/collection/hitchcock")
     * @param MovieRepository $movieRepository
     * @return Response
     */
    public function hitchcockCollection(MovieRepository $movieRepository){
        $hitchcockMovies = $movieRepository->findHitchcock();
        return $this->json($hitchcockMovies, Response::HTTP_OK, [], ['groups' => 'movie_read']);
    }

    /**
     * Return a collection of 3 movies from Fritz Lang
     * 
     * @Route("/collection/fritz-lang")
     * @param MovieRepository $movieRepository
     * @return Response
     */
    public function fritzLangCollection(MovieRepository $movieRepository){
        $fritzLangMovies = $movieRepository->findFritzLang();
        return $this->json($fritzLangMovies, Response::HTTP_OK, [], ['groups' => 'movie_read']);
    }
}
