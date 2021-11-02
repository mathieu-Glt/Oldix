<?php

namespace App\Controller\BackOffice;

use App\Entity\Comment;
use App\Repository\CommentRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class CommentController extends AbstractController
{
    /**
     * @Route("/backoffice/comments", name="backoffice_comments_list")
     */
    public function list(CommentRepository $commentRepository): Response
    {
        $allComments = $commentRepository->findAll();
        return $this->render('back_office/comment/index.html.twig', [
            'comments' => $allComments
        ]);
    }

    /**
     * @Route("/backoffice/comments/{id}/delete", name="backoffice_comments_delete")
     */
    public function delete(Comment $comment, EntityManagerInterface $em)
    {   
        $em->remove($comment);
        $em->flush();
        $this->addFlash('success', 'Comment deleted');
        return $this->redirectToRoute('backoffice_comments_list');
    }
}
