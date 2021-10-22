<?php

namespace App\Controller\Api;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class backOfficeController extends AbstractController
{
    /**
     * @Route("/api/back/office", name="api_back_office")
     */
    public function index(): Response
    {
        return $this->render('api/back_office/index.html.twig', [
            'controller_name' => 'backOfficeController',
        ]);
    }
}
