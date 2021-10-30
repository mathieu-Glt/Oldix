<?php

namespace App\Controller\Api;

use App\Entity\User;
use App\Entity\Language;
use App\Repository\UserRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class SecurityController extends AbstractController
{
    /**
     * 
     * @Route("/api/register",name="security_login",methods={"POST"})
     * 
     * @param Request $request
     * @param SerializerInterface $serializer
     * @param ValidatorInterface $validator
     * @param UserPasswordHasherInterface $passwordEncoder
     * @param UserRepository $userRepository
     * @return JsonResponse
     */
    public function registration(Request $request, SerializerInterface $serializer, ValidatorInterface $validator, UserPasswordHasherInterface $passwordEncoder, UserRepository $userRepository):JsonResponse
    {
        $user = $serializer->deserialize($request->getContent(), User::class, 'json');
       
        //Check if request is valid
        $errors = $validator->validate($user);
        $errorMessages = [];
        if (count($errors) !== 0) {
            foreach ($errors as $error) {
                $errorMessages[] = $error->getMessage();
            }
            $jsonResponse = [
                'messages' => $errorMessages,
                'error' => 400
            ];
            return $this->json($jsonResponse, 400);
        }

        //Check if email is already used
        $alreadyExists = $userRepository->findOneByEmail($user->getEmail());
        if ($alreadyExists) {
            $jsonResponse = [
                'message' => 'This email is already used in this website',
                'error' => '400'
            ];
            return $this->json($jsonResponse, 400);
        }

        //Insert in database
        $user->setRoles(['ROLE_USER']);
        $user->setPassword($passwordEncoder->hashPassword($user, $user->getPassword()));
        $em = $this->getDoctrine()->getManager();
        $em->persist($user);
        $em->flush();
        $jsonResponse = [
            'message' => 'User created',
        ];
        return $this->json($jsonResponse, 201);
    }

}
