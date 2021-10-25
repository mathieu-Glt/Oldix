<?php

namespace App\Controller\Api;

use App\Repository\MovieRepository;
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
     * 
     * @Route("/{slug}", name="api_thematics_read", methods={"GET"})
     * @param string $slug
     * @param ThematicRepository $thematicRepository
     * @param MovieRepository $movieRepository
     * @return Response
     */
    public function read(string $slug, ThematicRepository $thematicRepository, MovieRepository $movieRepository): Response
    {
        $thematic = $thematicRepository->findOneBySlug($slug);
        if(!$thematic){
            return $this->json([],404);
        }

        $movies = $movieRepository->findByThematic($thematic);     
        
        return $this->json($movies, 200,[],['groups'=>'read_thematic']);
    }
}
