<?php

namespace App\Controller\BackOffice;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

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
}
