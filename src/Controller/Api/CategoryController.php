<?php

namespace App\Controller\Api;

use App\Entity\Category;
use App\Repository\CategoryRepository;
use App\Repository\MovieRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

/**
 * @Route("/api/categories", name="api_category_")
 */
class CategoryController extends AbstractController
{
    /**
     * @Route("/", name="browse", methods={"GET"})
     * @param CategoryRepository $categoryRepository
     * @return Response
     */
    public function browse(CategoryRepository $categoryRepository): Response
    {
        $categories = $categoryRepository->findAll();

        return $this->json($categories, 200, [], ['groups' => 'browse_category']);
    }

    /**
     * Get all movies of a category
     * 
     * @Route("/{slug}", name="read", methods={"GET"})
     * @param Category $category
     * @param CategoryRepository $categoryRepository
     * @return Response
     */
    public function read(string $slug, CategoryRepository $categoryRepository, MovieRepository $movieRepository): Response
    {
        $category = $categoryRepository->findOneBySlug($slug);
        if (!$category) {
            return $this->json([
                'message' => 'This category does not exist',
                'errorCode' => '404'
            ], 404);
        }

        $movies = $movieRepository->findByCategory($category);

        return $this->json($movies, 200, [], ['groups' => 'read_category']);
    }

    /**
     * 
     * Get 10 first movies of a category
     * 
     * @Route("/{slug}/preview", name="preview", methods={"GET"})
     * @param [type] $slug
     * @param CategoryRepository $categoryRepository
     * @return Response
     */
    public function preview(string $slug, CategoryRepository $categoryRepository, MovieRepository $movieRepository): Response
    {
        $category = $categoryRepository->findOneBySlug($slug);
        if (!$category) {
            return $this->json([
                'message' => 'This category does not exist',
                'errorCode' => '404'
            ], 404);
        }
        $previewMovies = $movieRepository->findByCategory($category, 10);

        return $this->json($previewMovies, 200, [], ['groups' => 'read_category']);
    }
}
