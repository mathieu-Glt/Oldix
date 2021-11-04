<?php

namespace App\Controller\BackOffice;

use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;

/**
 * @Route("/backoffice/users/", name="backoffice_users_")
 * @IsGranted("ROLE_ADMIN")
 */
class UserController extends AbstractController
{
    /**
     * Display all users for the back-office
     * 
     * @Route("all", name="browse", methods={"GET"})
     * @param UserRepository $userRepository
     * @return Response
     */
    public function browse(UserRepository $userRepository): Response
    {
        $allUsers = $userRepository->findAll();
        return $this->render('back_office/user/all_users.html.twig', ['users' => $allUsers]);
    }

    
}
