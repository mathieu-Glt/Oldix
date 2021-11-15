<?php

namespace App\Controller\BackOffice;

use App\Entity\Comment;
use App\Repository\CommentRepository;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;

/**
 * @Route("/backoffice/comments",name="backoffice_comments_")
 * @IsGranted("ROLE_ADMIN")
 */
class CommentController extends AbstractController
{
    /**
     * @Route("/all", name="browse")
     */
    public function browse(CommentRepository $commentRepository, PaginatorInterface $paginator, Request $request): Response
    {
        $allComments = $paginator->paginate($commentRepository->findAll(),$request->query->get('page',1),10);
        return $this->render('back_office/comment/index.html.twig', [
            'comments' => $allComments
        ]);
    }

    /**
     * @Route("/{id}/delete", name="delete")
     */
    public function delete(Comment $comment, EntityManagerInterface $em)
    {
        $em->remove($comment);
        $em->flush();
        $this->addFlash('success', 'Comment deleted');
        return $this->redirectToRoute('backoffice_comments_browse');
    }
}
