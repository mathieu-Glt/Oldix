<?php

namespace App\Controller\BackOffice;

use App\Entity\Thematic;
use App\Form\ThematicType;
use App\Repository\ThematicRepository;
use App\Utils\Slug;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/backoffice/thematics/", name="backoffice_thematics_")
 * @IsGranted("ROLE_ADMIN")
 */
class ThematicController extends AbstractController
{
    /**
     * Display all thematics for the back-office
     * 
     * @Route("all", name="browse", methods={"GET"})
     * @param ThematicRepository $thematicRepository
     * @return Response
     */
    public function browse(ThematicRepository $thematicRepository): Response
    {
        $allThematics = $thematicRepository->findAll();
        return $this->render('back_office/thematic/all_thematics.html.twig', ['thematics' => $allThematics]);
    }

    /**
     * Delete a Thematic
     * 
     * @Route("delete/{slug}", name="delete", methods={"GET", "DELETE"})
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
        return $this->redirectToRoute("backoffice_thematics_browse");
    }

    /**
     * Edit a Thematic
     * 
     * @Route("edit/{slug}", name="edit", methods={"GET", "POST"})
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
        return $this->redirectToRoute('backoffice_thematics_browse');
       }
       return $this->render("back_office/thematic/edit.html.twig", ["form" => $thematicForm->createView()]);
    }

    /**
     * Add a new thematic
     * 
     * @Route("add", name="add")
     * @param EntityManager $entityManager
     * @param Request $request
     * @return Response
     */
    public function add(EntityManagerInterface $entityManager, Request $request, Slug $slug)
    {
        $thematic = new Thematic();
        $thematicForm = $this->createForm(ThematicType::class, $thematic);
        $thematicForm->handleRequest($request);
        if($thematicForm->isSubmitted() && $thematicForm->isValid()){
            $thematicSlugged = $slug->slugger($thematic->getName());
            $thematic->setSlug($thematicSlugged);
            $entityManager->persist($thematic);
            $entityManager->flush();
            $this->addFlash("success", "New category created");
            return $this->redirectToRoute('backoffice_thematics_browse');
        }
        return $this->render('back_office/thematic/add.html.twig', ["form" => $thematicForm->createView()]);
    }



}
