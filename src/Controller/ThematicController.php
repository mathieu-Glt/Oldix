<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ThematicController extends AbstractController
{
    /**
     * @Route("/thematic/thematic", name="thematic_thematic")
     */
    public function index(): Response
    {
        return $this->render('thematic_thematic/index.html.twig', [
            'controller_name' => 'ThematicThematicController',
        ]);
    }
}
