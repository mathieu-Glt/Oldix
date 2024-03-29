<?php

namespace App\Controller\BackOffice;

use App\Entity\Movie;
use App\Form\MovieType;
use App\Repository\MovieRepository;
use App\Utils\OmdbApi;
use App\Utils\Slug;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/backoffice/movies/", name="backoffice_movies_")
 * @IsGranted("ROLE_ADMIN")
 */
class MovieController extends AbstractController
{

    /**
     * Add a new movie in the databse
     * 
     * @Route("add", name="add", methods={"GET","POST"})
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
            $movieDuration = $array["Runtime"];
            $movieNameLowed = strtolower($movieTitle);
            $movieNameSlugged = $slug->slugger($movieNameLowed);
            $movie->setName($movieTitle);
            $movie->setReleasedDate($movieYear);
            $movie->setRealisator($movieRealisator);
            $movie->setRunTime($movieDuration);
            $movie->setSynopsis($movieSynopsis);
            $movie->setPictureUrl($moviePoster);
            $movie->setSlug($movieNameSlugged);
            $movie->setOwner($this->getUser());
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
     * @Route("all", name="browse", methods={"GET"})
     * @param MovieRepository $movieRepository
     * @return Response
     */
    public function browse(MovieRepository $movieRepository, PaginatorInterface $paginator, Request $request): Response
    {
        $allMovies = $paginator->paginate($movieRepository->findAll(), $request->query->getInt('page', 1), 6);
        //dd(($allMovies);
        return $this->render('back_office/movie/all_movies.html.twig', ['movies' => $allMovies]);
    }

    /**
     * Delete a movie
     * 
     * @Route("delete/{slug}", name="delete", methods={"GET"})
     * @param EntityManager $entityManager
     * @return Response
     */
    public function delete($slug, EntityManagerInterface $entityManager, MovieRepository $movieRepository): Response
    {
        $movieToRemove = $movieRepository->findOneBySlug($slug);
        $entityManager->remove($movieToRemove);
        $entityManager->flush();
        $this->addFlash('success', "Movie deleted");
        return $this->redirectToRoute("backoffice_movies_browse");
    }

    /**
     * Edit a movie
     * 
     * @Route("edit/{slug}", name="edit", methods={"GET", "POST"})
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
            return $this->redirectToRoute('backoffice_movies_all');
        }
        return $this->render("back_office/movie/edit.html.twig", ["form" => $movieForm->createView()]);
    }

    /**
     * Method for add a movie length for field released_date in adminer
     * 
     * @Route("test", methods={"GET"})
     * @param int $id
     * @param MovieRepository $movieRepository
     * @return Response
     */
    public function addDataToAdminer(MovieRepository $movieRepository, OmdbApi $omdbApi, Request $request): Response
    {

        for ($id = 9; $id < 139; $id++) {

            $entityManager = $this->getDoctrine()->getManager();
            // TODO récupérer la liste d'information d'un film dans le repository par id
            //dd($id);
            $movie =  $movieRepository->find($id);
            if ($movie !== null) {

                // TODO récupérer le nom d'un film
                $movieName = $movie->getName();
                $infosFromApi = $omdbApi->getInfosFromApi($movieName);
                $array = (array) $infosFromApi;
                $movieRunTime = $array['Runtime'];
                $movie->setRunTime($movieRunTime);
                $entityManager->persist($movie);
                $entityManager->flush();
            }
        }

        return new Response('data runtime added', 200);
    }
}
