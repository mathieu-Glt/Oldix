<?php

namespace App\Controller\BackOffice;

use App\Utils\Slug;
use App\Entity\Mood;

use App\Form\MoodType;
use App\Repository\MoodRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

/**
 * @Route("/backoffice/moods/", name="backoffice_moods_")
 * @IsGranted("ROLE_ADMIN")
 */
class MoodController extends AbstractController
{
    /**
     * @Route("all",name="browse")
     *
     * @param MoodRepository $moodRepository
     * @return Response
     */
    public function browse(MoodRepository $moodRepository): Response
    {
        $allmoods = $moodRepository->findAll();
        return $this->render('back_office/mood/all_moods.html.twig', [
            'moods' => $allmoods
        ]);
    }

    /**
     *  @Route("{slug}/edit",name="edit")
     *
     * @param Mood $mood
     * @param Request $request
     * @return Response
     */
    public function edit(Mood $mood, Request $request): Response
    {
        $form = $this->createForm(MoodType::class, $mood);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->flush();
            $this->addFlash('success', 'Mood ' . $mood->getName() . ' edited');
            return $this->redirectToRoute('backoffice_moods_browse');
        }
        return $this->render('back_office/mood/edit.html.twig', [
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("add",name="add")
     *
     * @param Request $request
     * @return Response
     */
    public function add(Request $request,Slug $slug): Response
    {
        $mood = new Mood();
        $form = $this->createForm(MoodType::class, $mood);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $mood->setSlug($slug->slugger($mood->getName()));
            $em->persist($mood);
            $em->flush();
            $this->addFlash('success', 'Mood ' . $mood->getName() . ' created');
            return $this->redirectToRoute('backoffice_moods_browse');
        }

        return $this->render('back_office/mood/add.html.twig', [
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("{slug}/delete",name="delete")
     *
     * @param Mood $mood
     * @param EntityManagerInterface $em
     * @return Response
     */
    public function delete(Mood $mood, EntityManagerInterface $em): Response
    {
        $em->remove($mood);
        $em->flush();
        $this->addFlash('success', 'Mood ' . $mood->getName() . ' deleted');
        return $this->redirectToRoute('backoffice_moods_browse');
    }
}
