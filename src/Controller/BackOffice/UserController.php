<?php

namespace App\Controller\BackOffice;

use App\Entity\User;
use App\Form\UserType;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Security\Core\Validator\Constraints\UserPassword;

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

    /**
     * Add a user for the back-office
     * 
     * @Route("add", name="add", methods={"GET", "POST"})
     * @param UserRepository $userRepository
     * @return Response
     */
    public function add(Request $request, UserPasswordHasherInterface $userPasswordHasherInterface): Response
    {
        $user = new User();
        $userForm = $this->createForm(UserType::class, $user);
        $userForm->handleRequest($request);
        if ($userForm->isSubmitted() && $userForm->isValid()){
            $entityManager = $this->getDoctrine()->getManager();
            $passwordHased = $userPasswordHasherInterface->hashPassword($user, $user->getPassword());
            $user->setPassword($passwordHased);
            $entityManager->persist($user);
            $entityManager->flush();
            return $this->redirectToRoute("backoffice_users_browse");
        }
        return $this->render('back_office/user/add.html.twig', ['form' => $userForm->createView()]);
    }

    
}
