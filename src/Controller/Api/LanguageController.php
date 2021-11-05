<?php

namespace App\Controller\Api;

use App\Repository\MovieRepository;
use App\Repository\LanguageRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

/**
 * @Route("/api/languages", name="api_languages_")
 */
class LanguageController extends AbstractController
{
    /**

     * Get all languages 
     * 
     * @Route("/", name="browse", methods={"GET"})
     * @param LanguageRepository $languageRepository
     * @return Response
     */
    public function browse(LanguageRepository $languageRepository): Response
    {

        $languages = $languageRepository->findAll();
        return $this->json($languages, Response::HTTP_OK, [], ['groups' => 'language_browse']);
    }

    /**
     * Get all movies of a language
     * 
     * @Route("/{slug}", name="read", methods={"GET"}, requirements={"slug":"^[a-z0-9]+(?:-[a-z0-9]+)*$"})
     * @param LanguageRepository $languageRepository
     * @param MovieRepository $movieRepository
     * @return Response
     */
    public function read(string $slug, MovieRepository $movieRepository, LanguageRepository $languageRepository): Response
    {

        $language = $languageRepository->findOneBySlug($slug);
        if (!$language) {
            return $this->json([
                'message' => 'This language does not exist',
                'code' => Response::HTTP_NOT_FOUND
            ], Response::HTTP_NOT_FOUND);
        } else {
            $movies = $movieRepository->findByLanguage($language);
        }
        return $this->json($movies, Response::HTTP_OK, [], ['groups' => 'movie_read']);
    }
}
