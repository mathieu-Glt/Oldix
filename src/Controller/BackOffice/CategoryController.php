<?php

namespace App\Controller\BackOffice;

use App\Entity\Category;
use App\Form\CategoryType;
use App\Repository\CategoryRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Mapping\Entity;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/backoffice")
 * @IsGranted("ROLE_ADMIN")
 */
class CategoryController extends AbstractController
{
    /**
     * Display all categories for the back-office
     * 
     * @Route("/categories/all", name="backoffice_categories_all", methods={"GET"})
     * @param CategoryRepository $categoryRepository
     * @return Response
     */
    public function allCategories(CategoryRepository $categoryRepository): Response
    {
        $allCategories = $categoryRepository->findAll();
        return $this->render('back_office/category/all_categories.html.twig', ['categories' => $allCategories]);
    }

    /**
     * Delete a category
     * 
     * @Route("/categories/delete/{slug}", name="backoffice_categories_delete", methods={"GET", "DELETE"})
     * @param EntityManagerInterface $entityManager
     * @param CategoryRepository $categoryRepository
     * @return Response
     */
    public function delete($slug, EntityManagerInterface $entityManager, CategoryRepository $categoryRepository): Response
    {
        $categoryToDelete = $categoryRepository->findOneBySlug($slug);
        $entityManager->remove($categoryToDelete);
        $entityManager->flush();
        $this->addFlash("success", "Category deleted");
        return $this->redirectToRoute("backoffice_categories_all");
    }

    /**
     * Edit a Category
     * 
     * @Route("/categories/edit/{slug}", name="backoffice_categories_edit", methods={"GET", "POST"})
     * @param EntityManager $entityManager
     * @param CategoryRepository $categoryRepository
     * @param Request $request
     * @return Response
     */
    public function edit($slug, EntityManagerInterface $entityManager,CategoryRepository $categoryRepository, Request $request): Response 
    {
       $categoryToEdit = $categoryRepository->findOneBySlug($slug);
       $categoryForm = $this->createForm(CategoryType::class, $categoryToEdit);
       $categoryForm->handleRequest($request);
       if($categoryForm->isSubmitted() && $categoryForm->isValid()){
        $entityManager->flush();
        $this->addFlash('success', "Category edited");
        return $this->redirectToRoute('backoffice_categories_all');
       }
       return $this->render("back_office/category/edit.html.twig", ["form" => $categoryForm->createView()]);
    }

    /**
     * Add a new cateogory
     * 
     * @Route("/categories/add", name="backoffice_categories_add")
     * @param EntityManager $entityManager
     * @param Request $request
     * @return Response
     */
    public function add(EntityManagerInterface $entityManager, Request $request)
    {
        $category = new Category();
        $categoryForm = $this->createForm(CategoryType::class, $category);
        $categoryForm->handleRequest($request);
        if($categoryForm->isSubmitted() && $categoryForm->isValid()){
            $entityManager->persist($category);
            $entityManager->flush();
            $this->addFlash("success", "New category created");
            return $this->redirectToRoute('backoffice_categories_all');
        }
        return $this->render('back_office/category/add.html.twig', ["form" => $categoryForm->createView()]);
    }
}
