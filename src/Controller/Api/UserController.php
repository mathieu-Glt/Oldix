<?php

namespace App\Controller\Api;

use App\Entity\User;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/api/user")
 */
class UserController extends AbstractController
{
    /**
     * Edit user's informations
     * 
     * @Route("/edit/{id}", name="api_user_edit")
     */
    public function edit($id, User $user, UserRepository $userRepository, EntityManagerInterface $entityManager, Request $request, UserPasswordHasherInterface $passwordEncoder): Response
    {
        // i check if the user is connected
        $user = $this->getUser();
        if(!$user) {
            $jsonResponse = [
                'message' => 'User not connected',
                'code' => Response::HTTP_UNAUTHORIZED
            ];
            return $this->json($jsonResponse, Response::HTTP_UNAUTHORIZED);
        }
        $newEmail = json_decode($request->getContent(), true)["email"];
        $newPseudo = json_decode($request->getContent(), true)["pseudo"];
        $newPassword = json_decode($request->getContent(), true)["password"];
        $userToChange = $userRepository->findOneById($id);
        if($newEmail !== $userToChange->getEmail()){
            // chercher dans la bdd si l'email existe deja
            $userToChange->setEmail($newEmail);
        }
        if($newPseudo !== $userToChange->getPseudo()){
            $userToChange->setPseudo($newPseudo);
        }
        $userToChange->setPassword($passwordEncoder->hashPassword($userToChange, $newPassword));
        $entityManager->flush();
        $jsonResponse = [
            'code' => Response::HTTP_OK,
            'message' => "User edited"
        ];
        return $this->json($jsonResponse, Response::HTTP_OK);

    }
}
