<?php

namespace App\Controller\BackOffice;

use App\Entity\Movie;
use App\Form\MovieType;
use App\Repository\MovieRepository;
use App\Utils\OmdbApi;
use App\Utils\Slug;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/backoffice")
 * @IsGranted("ROLE_ADMIN")
 */
class MovieController extends AbstractController
{

    /**
     * Add a new movie in the databse
     * 
     * @Route("/movies/add", name="backoffice_add", methods={"GET","POST"})
     * @param Request $request
     * @param OmdbApi $omdbApi
     * @return Response
     */
    public function add(Request $request, OmdbApi $omdbApi, Slug $slug): Response
    {
        $movie = new Movie();
        $movieForm = $this->createForm(MovieType::class, $movie);
        $movieForm->handleRequest($request);
        if ($movieForm->isSubmitted() && $movieForm->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $infosFromApi = $omdbApi->getInfosFromApi($movie->getName());
            $array = (array) $infosFromApi;
            $movieTitle = $array['Title'];
            $movieYear = $array['Year'];
            $movieSynopsis = $array["Plot"];
            $movieRealisator = $array["Director"];
            $moviePoster = $array["Poster"];
            $movieNameLowed = strtolower($movieTitle);
            $movieNameSlugged = $slug->slugger($movieNameLowed);
            $movie->setName($movieTitle);
            $movie->setReleasedDate($movieYear);
            $movie->setRealisator($movieRealisator);
            $movie->setSynopsis($movieSynopsis);
            $movie->setPictureUrl($moviePoster);
            $movie->setSlug($movieNameSlugged);
            $entityManager->persist($movie);
            $entityManager->flush();
            $this->addFlash('success', "New movie added");
            return $this->redirectToRoute('backoffice');
        }
        return $this->render("back_office/movie/add.html.twig", ['form' => $movieForm->createView()]);
    }


    /**
     * Display all movies for the back-office
     * 
     * @Route("/movies/all", name="backoffice_all", methods={"GET"})
     * @param MovieRepository $movieRepository
     * @return Response
     */
    public function allMovies(MovieRepository $movieRepository): Response
    {
        $allMovies = $movieRepository->findAll();
        return $this->render('back_office/movie/all_movies.html.twig', ['movies' => $allMovies]);
    }

    /**
     * Delete a movie
     * 
     * @Route("/movies/delete/{slug}", name="backoffice_delete", methods={"GET"})
     * @param EntityManager $entityManager
     * @return Response
     */
    public function delete($slug, EntityManagerInterface $entityManager, MovieRepository $movieRepository): Response
    {
        $movieToRemove = $movieRepository->findOneBySlug($slug);
        $entityManager->remove($movieToRemove);
        $entityManager->flush();
        $this->addFlash('success', "Movie deleted");
        return $this->redirectToRoute("backoffice_all");
    }

    /**
     * Edit a movie
     * 
     * @Route("/movies/edit/{slug}", name="backoffice_edit", methods={"GET", "POST"})
     * @param EntityManager $entityManager
     * @param MovieRepository $movieRepository
     * @param Request $request
     * @return Response
     */
    public function edit($slug, EntityManagerInterface $entityManager, MovieRepository $movieRepository, Request $request): Response
    {
        $movieToEdit = $movieRepository->findOneBySlug($slug);
        $movieForm = $this->createForm(MovieType::class, $movieToEdit);
        $movieForm->handleRequest($request);
        if ($movieForm->isSubmitted() && $movieForm->isValid()) {
            $entityManager->flush();
            $this->addFlash('success', "Movie edited");
            return $this->redirectToRoute('backoffice_all');
        }
        return $this->render("back_office/movie/edit.html.twig", ["form" => $movieForm->createView()]);
    }
}
