<?php

namespace App\Controller;

use App\Entity\Category;
use App\Repository\CategoryRepository;
use App\Repository\MovieRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

/**
 * @Route("/api/categories")
 */
class CategoryController extends AbstractController
{
    /**
     * @Route("/", name="app_category_browse", methods={"GET"})
     * @param CategoryRepository $categoryRepository
     * @return Response
     */
    public function browse(CategoryRepository $categoryRepository): Response
    {
        $categories = $categoryRepository->findAll();
        return $this->json($categories, 200);
    }

    /**
     * Get all movies of a category
     * 
     * @Route("/{slug}/movies", name="app_category_read", methods={"GET"})
     * @param Category $category
     * @param CategoryRepository $categoryRepository
     * @return Response
     */
    public function read($slug, MovieRepository $movieRepository): Response
    {   
        $category = $movieRepository->findOneBySlug($slug);
        if(!$category){
            return $this->json([],404);
        }else{
            $movies = $movieRepository->findByCategory($category);
        }
        return $this->json($movies, 200);
    }

    /**
     * 
     * Get 10 first movies of a category
     * 
     * @Route("/{slug}/movies/preview", name="app_category_preview", methods={"GET"})
     * @param [type] $slug
     * @param CategoryRepository $categoryRepository
     * @return Response
     */
    public function preview($slug, MovieRepository $movieRepository): Response
    {
        $category = $movieRepository->findOneBySlug($slug);
        if(!$category){
            return $this->json([],404);
        }else{
            $previewMovies = $movieRepository->findByCategory($category,10);
            return $this->json($previewMovies, 200);
        }
    }
}
