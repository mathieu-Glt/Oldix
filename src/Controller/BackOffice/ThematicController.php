<?php

namespace App\Controller\BackOffice;

use App\Form\ThematicType;
use App\Repository\ThematicRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/backoffice")
 * @IsGranted("ROLE_ADMIN")
 */
class ThematicController extends AbstractController
{
    /**
     * Display all thematics for the back-office
     * 
     * @Route("/thematics/all", name="backoffice_thematics_all", methods={"GET"})
     * @param ThematicRepository $thematicRepository
     * @return Response
     */
    public function allMovies(ThematicRepository $thematicRepository): Response
    {
        $allThematics = $thematicRepository->findAll();
        return $this->render('back_office/thematic/all_thematics.html.twig', ['thematics' => $allThematics]);
    }

    /**
     * Delete a Thematic
     * 
     * @Route("/thematics/delete/{slug}", name="backoffice_thematics_delete", methods={"GET", "DELETE"})
     * @param ThematicRepository $thematicRepository
     * @param EntityManagerInterface $entityManager
     * @return Response
     */
    public function delete($slug, ThematicRepository $thematicRepository, EntityManagerInterface $entityManager): Response
    {
        $thematicToDelete = $thematicRepository->findOneBySlug($slug);
        $entityManager->remove($thematicToDelete);
        $entityManager->flush();
        $this->addFlash("success", "Thematic deleted");
        return $this->redirectToRoute("backoffice_thematics_all");
    }

    /**
     * Edit a Thematic
     * 
     * @Route("/thematics/edit/{slug}", name="backoffice_thematics_edit", methods={"GET", "POST"})
     * @param EntityManager $entityManager
     * @param ThematicRepository $thematicRepository
     * @param Request $request
     * @return Response
     */
    public function edit($slug, EntityManagerInterface $entityManager,ThematicRepository $thematicRepository, Request $request): Response 
    {
       $thematicToEdit = $thematicRepository->findOneBySlug($slug);
       $thematicForm = $this->createForm(ThematicType::class, $thematicToEdit);
       $thematicForm->handleRequest($request);
       if($thematicForm->isSubmitted() && $thematicForm->isValid()){
        $entityManager->flush();
        $this->addFlash('success', "Thematic edited");
        return $this->redirectToRoute('backoffice_thematics_all');
       }
       return $this->render("back_office/thematic/edit.html.twig", ["form" => $thematicForm->createView()]);
    }



}
