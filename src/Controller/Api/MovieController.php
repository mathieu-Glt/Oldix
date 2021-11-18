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
     * @Route("/banner/1", name="banner", methods={"GET"})
     * @param MovieRepository $movieRepository
     * @return Response
     */
    public function banner(MovieRepository $movieRepository): Response
    {
        $bannerMovie = $movieRepository->findOneById(30);
        return $this->json($bannerMovie, Response::HTTP_OK, [], ['groups' => 'movie_read']);
    }

    /**
     * 
     * @Route("/banner/2", name="banner2", methods={"GET"})
     * @param MovieRepository $movieRepository
     * @return Response
     */
    public function banner2(MovieRepository $movieRepository): Response
    {
        $bannerMovie = $movieRepository->findOneById(135);
        return $this->json($bannerMovie, Response::HTTP_OK, [], ['groups' => 'movie_read']);
    }

    /**
     * 
     * @Route("/banner/home", name="bannerHome", methods={"GET"})
     * @param MovieRepository $movieRepository
     * @return Response
     */
    public function bannerHome(MovieRepository $movieRepository): Response
    {
        $bannerMovie = $movieRepository->findOneById(139);
        return $this->json($bannerMovie, Response::HTTP_OK, [], ['groups' => 'movie_read']);
    }

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
     * @Route("/randoms", name="randoms")
     * @param MovieRepository $movieRepository
     * @return Response
     */
    public function manyRandom(MovieRepository $movieRepository):Response
    {
        $allMovies = $movieRepository->findAll();
        $randomMovies = [];
        $randomKey = array_rand($allMovies, 15);
        foreach($randomKey as $key){
            $randomMovies[] = $allMovies[$key];
        }

        return $this->json($randomMovies, Response::HTTP_OK, [], ['groups' => 'movie_browse']);
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
     * Return a collection of 4 movies from Fritz Lang
     * 
     * @Route("/collection/fritz-lang")
     * @param MovieRepository $movieRepository
     * @return Response
     */
    public function fritzLangCollection(MovieRepository $movieRepository){
        $fritzLangMovies = $movieRepository->findFritzLang();
        return $this->json($fritzLangMovies, Response::HTTP_OK, [], ['groups' => 'movie_read']);
    }

    /**

     * Return all movies of 1910 to 1919
     * 
     * @Route("/collection/tenties")
     * @param MovieRepository $movieRepository
     * @return Response
     */
    public function findMoviesCollectionTenties(MovieRepository $movieRepository){

        
        $findMoviesByTenties = $movieRepository->findMoviesByTenties();
        //dd($findByDate);
        return $this->json($findMoviesByTenties, Response::HTTP_OK, [], ['groups' => 'movie_read']);
    }


    /**
     * Return all movies of 1920 to 1929
     * 
     * @Route("/collection/twenties")
     * @param MovieRepository $movieRepository
     * @return Response
     */
    public function findMoviesCollectionTwenties(MovieRepository $movieRepository){

        
        $findMoviesByTwenties = $movieRepository->findMoviesByTwenties();
        //dd($findByDate);
        return $this->json($findMoviesByTwenties, Response::HTTP_OK, [], ['groups' => 'movie_read']);
    }


    /**
     * Return all movies of 1930 to 1939
     * 
     * @Route("/collection/thirties")
     * @param MovieRepository $movieRepository
     * @return Response
     */
    public function findMoviesCollectionThirties(MovieRepository $movieRepository){

        
        $findMoviesByThirties = $movieRepository->findMoviesByThirties();
        //dd($findByDate);
        return $this->json($findMoviesByThirties, Response::HTTP_OK, [], ['groups' => 'movie_read']);
    }

    /**
     * Return all movies of 1940 to 1949
     * 
     * @Route("/collection/forties")
     * @param MovieRepository $movieRepository
     * @return Response
     */
    public function findMoviesCollectionForties(MovieRepository $movieRepository){

        
        $findMoviesByForties = $movieRepository->findMoviesByForties();
        //dd($findByDate);
        return $this->json($findMoviesByForties, Response::HTTP_OK, [], ['groups' => 'movie_read']);
    }

    /**
     * Return all movies of 1950 to 1959
     * 
     * @Route("/collection/fifties")
     * @param MovieRepository $movieRepository
     * @return Response
     */
    public function findMoviesCollectionFifties(MovieRepository $movieRepository){

        
        $findMoviesByFifties = $movieRepository->findMoviesByFifties();
        //dd($findByDate);
        return $this->json($findMoviesByFifties, Response::HTTP_OK, [], ['groups' => 'movie_read']);
    }

    /**
     * Return all movies of 1960 to 1969
     * 
     * @Route("/collection/sixties")
     * @param MovieRepository $movieRepository
     * @return Response
     */
    public function findMoviesCollectionSixties(MovieRepository $movieRepository){

        
        $findMoviesBySixties = $movieRepository->findMoviesBySixties();
        //dd($findByDate);
        return $this->json($findMoviesBySixties, Response::HTTP_OK, [], ['groups' => 'movie_read']);
    }

    /**
     * Return all movies of 1970 to 1979
     * 
     * @Route("/collection/seventies")
     * @param MovieRepository $movieRepository
     * @return Response
     */
    public function findMoviesCollectionSeventies(MovieRepository $movieRepository){

        
        $findMoviesBySeventies = $movieRepository->findMoviesBySeventies();
        //dd($findByDate);
        return $this->json($findMoviesBySeventies, Response::HTTP_OK, [], ['groups' => 'movie_read']);
    }

    /**
     * Return all movies of 1980 to 1989
     * 
     * @Route("/collection/eighties")
     * @param MovieRepository $movieRepository
     * @return Response
     */
    public function findMoviesCollectionEighties(MovieRepository $movieRepository){

        
        $findMoviesByEighties = $movieRepository->findMoviesByEighties();
        return $this->json($findMoviesByEighties, Response::HTTP_OK, [], ['groups' => 'movie_read']);
    }

    /** Return all movies
     * 
     * @Route("/allMovies", methods={"GET"})
     * @param MovieRepository $movieRepository
     * @return Response
     */
    public function all(MovieRepository $movieRepository){
        $allMovies = $movieRepository->findAll();
        return $this->json($allMovies, Response::HTTP_OK, [], ['groups' => 'movie_read']);
    }

}
