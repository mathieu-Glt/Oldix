<?php

namespace App\Controller\Api;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class LanguageController extends AbstractController
{
    /**

     * Get all languages 
     * 
     * @Route("api/languages", name="language_list, methods={"GET"})
     * @param LanguageRepository $languageRepository
     * @return Response
     */
    public function browse(LanguageRepository $languageRepository): Response
    {   

        $languages = $languageRepository->findAll();
        return $this->json($languages, 200);
        
    
    }

    /**
     * Get all movies of a language
     * 
     * @Route("api/languages/{slug}", name="app_language", methods={"GET"})
     * @param LanguageRepository $languageRepository
     * @param MovieRepository $movieRepository
     * @return Response
     */
    public function read(string $slug, MovieRepository $movieRepository, LanguageRepository $languageRepository): Response
    {   

        $language = $languageRepository->findOneBySlug($slug);
        if (!$language) {
            return $this->json([], 404);
        } else {
            $movies = $movieRepository->findByLanguage($language);

        }
        return $this->json($movies, 200);
    
    }


}
