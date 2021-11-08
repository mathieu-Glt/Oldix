<?php

namespace App\Controller\BackOffice;

use App\Repository\CategoryRepository;
use App\Repository\CommentRepository;
use App\Repository\MovieRepository;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;



class MainController extends AbstractController
{
    /**
     * @Route("/", name="route_page_home")
     */
    public function index(): Response
    {
        return $this->render('back_office/main/index.html.twig', [
            'controller_name' => 'MainController',
        ]);
    }

    /**
     * Display home page
     * 
     * @Route("/backoffice", name="backoffice")
     * @IsGranted("ROLE_ADMIN")
     * @return Response
     */
    public function homePage(MovieRepository $movieRepository, CategoryRepository $categoryRepository, UserRepository $userRepository, CommentRepository $commentRepository): Response
    {
        $lastMovies = $movieRepository->findBy([], ['id' => 'DESC'], 5);
        $lastCategories = $categoryRepository->findBy([], ['id' => 'DESC'], 5);
        $lastUsers = $userRepository->findBy([], ['id' => 'DESC'], 5);
        $lastComments = $commentRepository->findBy([], ['id' => 'DESC'], 5);
        
        return $this->render('back_office/movie/index.html.twig', [
            'lastMovies' => $lastMovies,
            'lastCategories' => $lastCategories,
            'lastUsers' => $lastUsers,
            'lastComments' => $lastComments
        ]);
    }
}
