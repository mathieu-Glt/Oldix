<?php

namespace App\Controller\Api;

use App\Repository\LanguageRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class LanguageController extends AbstractController
{
    /**
     * @Route("api/languages", name="language_list, methods={"GET"})
     */
    public function list(LanguageRepository $languageRepository): Response
    {   

        $listLanguage = $languageRepository->findAll();

        return $this->render(
            'list.html.twig',
            ['listLanguage' => $listLanguage,
        ]);
        
    );
    }

        /**
     * @Route("api/{slug}/language", name="app_language", methods={"GET"})
     * @param Movie $movie
     * @param MovieRepository $movieRepository
     * @return Response
     */
    public function read($slug, MovieRepository $movieRepository): Response
    {   

        $detailsMovie = $movieRepository->findByOneSlug($slug);
        
        if (!$detailsMovie) {
            return $this->json([], 404);
        } else {
            return $this->json($detailsMovie, 200);

        }
    );
    }

}
