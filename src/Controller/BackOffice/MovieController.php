<?php

namespace App\Controller\BackOffice;

use App\Entity\Movie;
use App\Form\MovieType;
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

    /**
     * @Route("/backoffice/movies/add", name="back_office_movie")
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

}
