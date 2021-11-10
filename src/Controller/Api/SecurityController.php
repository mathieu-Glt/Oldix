<?php

namespace App\Controller\Api;

use App\Entity\User;
use App\Entity\Language;
use App\Repository\UserRepository;
use ContainerCcMi9aj\getLexikJwtAuthentication_GenerateTokenCommandService;
use Lexik\Bundle\JWTAuthenticationBundle\Services\JWTTokenManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
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
    public function registration(JWTTokenManagerInterface $jwt, Request $request, SerializerInterface $serializer, ValidatorInterface $validator, UserPasswordHasherInterface $passwordEncoder, UserRepository $userRepository): JsonResponse
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
                'code' => Response::HTTP_BAD_REQUEST
            ];
            return $this->json($jsonResponse, Response::HTTP_BAD_REQUEST);
        }

        //Check if email is already used
        $alreadyExists = $userRepository->findOneByEmail($user->getEmail());
        if ($alreadyExists) {
            $jsonResponse = [
                'message' => 'This email is already used in this website',
                'code' => Response::HTTP_BAD_REQUEST
            ];
            return $this->json($jsonResponse, Response::HTTP_BAD_REQUEST);
        }

        //Insert in database
        $user->setRoles(['ROLE_USER']);
        $user->setPassword($passwordEncoder->hashPassword($user, $user->getPassword()));
        $em = $this->getDoctrine()->getManager();
        $em->persist($user);
        $em->flush();        
        $jwtManager = $jwt->create($user);
        $jsonResponse = [
            'message' => 'User created',
            'token'=>$jwtManager,
            'code' => Response::HTTP_CREATED
        ];
        return $this->json($jsonResponse, Response::HTTP_CREATED);
    }
}
