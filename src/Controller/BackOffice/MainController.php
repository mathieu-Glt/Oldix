<?php

namespace App\Controller\BackOffice;

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
    public function homePage():Response
    {
        return $this->render('back_office/movie/index.html.twig');
    }
}
