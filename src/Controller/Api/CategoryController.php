<?php

namespace App\Controller\Api;

use App\Entity\Category;
use App\Repository\MovieRepository;
use App\Repository\CategoryRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

/**
 * @Route("/api/categories", name="api_category_")
 */
class CategoryController extends AbstractController
{
    /**
     * @Route("/banner/{tier}", name="banner", methods={"GET"})
     * @param CategoryRepository $categoryRepository
     * @return Response
     */
    public function banner(string $tier, CategoryRepository $categoryRepository): Response
    {
        $categories = $categoryRepository->findAll();
        $result = [];
        if($tier == "1"){
            $result[] = $categories[0];
            $result[] = $categories[1];
            $result[] = $categories[2];
        } elseif ($tier == "2") {
            $result[] = $categories[3];
            $result[] = $categories[4];
            $result[] = $categories[5];  
        } elseif ($tier == "3"){
            $result[] = $categories[6];
            $result[] = $categories[7];
            $result[] = $categories[8];
        }
        return $this->json($result, Response::HTTP_OK, [], ['groups' => 'category_browse']);
    }

    /**
     * @Route("/", name="browse", methods={"GET"})
     * @param CategoryRepository $categoryRepository
     * @return Response
     */
    public function browse(CategoryRepository $categoryRepository): Response
    {
        $categories = $categoryRepository->findAll();
        return $this->json($categories, Response::HTTP_OK, [], ['groups' => 'category_browse']);
    }

    /**
     * Get all movies of a category
     * 
     * @Route("/{slug}", name="read", methods={"GET"}, requirements={"slug":"^[a-z0-9]+(?:-[a-z0-9]+)*$"})
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
                'code' => Response::HTTP_NOT_FOUND
            ], response::HTTP_NOT_FOUND);
        }

        $movies = $movieRepository->findByCategory($category);

        return $this->json($movies, Response::HTTP_OK, [], ['groups' => 'category_read']);
    }

    /**
     * 
     * Get 10 first movies of a category
     * 
     * @Route("/{slug}/preview", name="preview", methods={"GET"}, requirements={"slug":"^[a-z0-9]+(?:-[a-z0-9]+)*$"})
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
                'errorCode' => Response::HTTP_NOT_FOUND
            ], Response::HTTP_NOT_FOUND);
        }
        $previewMovies = $movieRepository->findByCategory($category, 10);

        return $this->json($previewMovies, Response::HTTP_OK, [], ['groups' => 'category_read']);
    }
}
