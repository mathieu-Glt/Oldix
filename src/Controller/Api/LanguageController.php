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

        return $this->json($listLanguage, 200);
        
    );
    }

    /**
     * @Route("api/languages/{slug}", name="app_language", methods={"GET"})
     * @param Language $language
     * @param LanguageRepository $languageRepository
     * @return Response
     */
    public function read($slug, LanguageRepository $languageRepository): Response
    {   

        $language = $languageRepository->findByOneSlug($slug);
        
        if (!$language) {
            $languagejson([], 404);
        } else {
            return $this->findByLanguage($language);

        }
        return $this->json($movies);
    );
    }

}
