<?php

namespace App\Controller\BackOffice;

use App\Utils\Slug;
use App\Entity\Language;
use App\Form\LanguageType;
use App\Repository\LanguageRepository;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

/**
 * @Route("/backoffice/languages", name="backoffice_languages_")
 * @IsGranted("ROLE_ADMIN")
 */
class LanguageController extends AbstractController
{
    private $slug;

    public function __construct(Slug $slug)
    {
        $this->slug = $slug;
    }
    /**
     * @Route("/all", name="browse", methods={"GET"})
     */
    public function browse(LanguageRepository $languageRepository, PaginatorInterface $paginator, Request $request): Response
    {
        $allLanguages = $paginator->paginate($languageRepository->findAll(), $request->query->getInt('page', 1), 10);
        return $this->render('back_office/language/all_languages.html.twig', [
            'languages' => $allLanguages
        ]);
    }

    /**
     * @Route("/{slug}/edit", name="edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Language $language): Response
    {
        $this->denyAccessUnlessGranted("language_edit", $language, "access denied");
        $form = $this->createForm(LanguageType::class, $language);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $language->setSlug($this->slug->slugger($language->getName()));
            $em = $this->getDoctrine()->getManager();
            $em->flush();
            $this->addFlash('success', 'Language "' . $language->getName() . '" edited');
            return $this->redirectToRoute('backoffice_languages_browse');
        }
        return $this->render('back_office/language/edit.html.twig', [
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/add", name="add", methods={"GET","POST"})
     */
    public function add(Request $request)
    {
        $language = new Language;
        $form = $this->createForm(LanguageType::class, $language);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $language->setSlug($this->slug->slugger($language->getName()));
            $language->setOwner($this->getUser());
            $em = $this->getDoctrine()->getManager();
            $em->persist($language);
            $em->flush();
            $this->addFlash('success', 'Language "' . $language->getName() . '" created');
            return $this->redirectToRoute('backoffice_languages_browse');
        }
        return $this->render('back_office/language/add.html.twig', [
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/{slug}/delete", name="delete", methods={"GET"})
     */
    public function delete(Language $language, EntityManagerInterface $em)
    {
        $this->denyAccessUnlessGranted("language_delete", $language, "access denied");
        $em->remove($language);
        $em->flush();
        $this->addFlash('success', 'Language "' . $language->getName() . '" deleted');
        return $this->redirectToRoute('backoffice_languages_browse');
    }
}
