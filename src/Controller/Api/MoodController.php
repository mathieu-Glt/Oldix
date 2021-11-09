<?php

namespace App\Controller\Api;

use App\Repository\MoodRepository;
use App\Repository\MovieRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

/**
 * @Route("/api/moods")
 */
class MoodController extends AbstractController
{
    /**
     * @Route("/")
     * @param MoodRepository $moodRepository
     * @return Response
     */
    public function browse(MoodRepository $moodRepository): Response
    {
        $allMoods = $moodRepository->findAll();
        return $this->json($allMoods, Response::HTTP_OK, [], ['groups' => 'mood_browse']);
    }

    /**
     * 
     * @Route("/{slug}")
     * @param string $slug
     * @param MoodRepository $moodRepository
     * @param MovieRepository $movieRepository
     * @return Response
     */
    public function read(string $slug, MoodRepository $moodRepository, MovieRepository $movieRepository): Response
    {
        $mood = $moodRepository->findOneBySlug($slug);
        if (!$mood) {
            return $this->json([
                'message' => 'This mood does not exist',
                'code' => Response::HTTP_NOT_FOUND
            ], Response::HTTP_NOT_FOUND);
        }

        $relatedCategories = $mood->getCategories()->toArray();
        $categoryIds = [];
        foreach($relatedCategories as $category){
            $categoryIds[] = $category->getId();
        }
        if(empty($categoryIds)){
            return $this->json([
                'message' => 'There is currently no movie for this mood.',
                'code' => Response::HTTP_NOT_FOUND
            ], Response::HTTP_NOT_FOUND);
        }
        $relatedMovies = $movieRepository->findByCategories($categoryIds);
        return $this->json($relatedMovies, Response::HTTP_OK, [], ['groups' => 'mood_read']);
    }
}
