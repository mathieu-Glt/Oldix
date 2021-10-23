<?php

namespace App\Controller\Api;

use App\Repository\ThematicRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/api/thematics")
 */
class ThematicController extends AbstractController
{
    /**
     * @Route("/", name="api_thematics_browse", methods={"GET"})
     */
    public function browse(ThematicRepository $thematicRepository): Response
    {
        $thematics = $thematicRepository->findAll();

        return $this->json($thematics, 200,[],['groups'=>'browse_thematic']);
    }

    /**
     * @Route("/{slug}", name="api_thematics_read", methods={"GET"})
     */
    public function read(string $slug, ThematicRepository $thematicRepository): Response
    {
        $thematic = $thematicRepository->findOneBySlug($slug);
        if(!$thematic){
            return $this->json([],404);
        }

        $movies = $thematicRepository->findByThematic($thematic);     
        
        return $this->json($movies, 200,[],['groups'=>'read_thematic']);
    }
}
