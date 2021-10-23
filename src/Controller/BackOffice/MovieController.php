<?php

namespace App\Controller\BackOffice;

use App\Entity\Movie;
use App\Form\MovieType;
use App\Repository\MovieRepository;
use App\Utils\OmdbApi;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MovieController extends AbstractController
{
    /**
     * @Route("/backoffice", name="back_office")
     */
    public function homePage()
    {
        return $this->render('back_office/movie/index.html.twig');
    }

    //Add a new movie
    /**
     * @Route("/backoffice/movies/add", name="back_office_movie_add")
     */
    public function add(Request $request, OmdbApi $omdbApi)
    {
        $movie = new Movie();
        $movieForm = $this->createForm(MovieType::class, $movie);
        $movieForm->handleRequest($request);
        if($movieForm->isSubmitted() && $movieForm->isValid()){
            $entityManager = $this->getDoctrine()->getManager();
            $infosFromApi = $omdbApi->getInfosFromApi($movie->getName());
            $array = (array) $infosFromApi;
            $movieTitle = $array['Title'];
            $movieYear = $array['Year'];
            $movieSynopsis = $array["Plot"];
            $movieRealisator = $array["Director"];
            $moviePoster = $array["Poster"];
            $movieNameLowed = strtolower($movieTitle);
            $movieNameSlugged = $this->slugger($movieNameLowed);
            $movie->setName($movieTitle);
            $movie->setReleasedDate($movieYear);
            $movie->setRealisator($movieRealisator);
            $movie->setSynopsis($movieSynopsis);
            $movie->setPictureUrl($moviePoster);
            $movie->setSlug($movieNameSlugged);
            $entityManager->persist($movie);
            $entityManager->flush();
            $this->addFlash('success', "New movie added");
            return $this->redirectToRoute('back_office');
        }
        return $this->render("back_office/movie/add.html.twig", ['form' => $movieForm->createView()]);
    }


    public function slugger($movieNameToSlug)
    {
        $slugged = preg_replace('~[^\pL\d]+~u', '-', $movieNameToSlug);
        return $slugged;
    }

    /**
     * @Route("/backoffice/movies/all", name="back_office_all_movies")
     */
    public function allMovies(MovieRepository $movieRepository)
    {
        $allMovies = $movieRepository->findAll();
        return $this->render('back_office/movie/all_movies.html.twig', ['movies' => $allMovies]);
    }

}
