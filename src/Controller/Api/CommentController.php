<?php

namespace App\Controller\Api;

use App\Entity\Comment;
use App\Repository\CommentRepository;
use App\Repository\MovieRepository;
use DateTimeImmutable;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class CommentController extends AbstractController
{
    /**
     * 
     * @Route("/api/movies/{slug}/comments/add",methods={"POST"})
     * @return Response
     */
    public function add(string $slug, SerializerInterface $serializer, Request $request, MovieRepository $movieRepository, EntityManagerInterface $em, ValidatorInterface $validator): Response
    {

        $movieToAddToComment = $movieRepository->findOneBySlug($slug);
        if (!$movieToAddToComment) {
            $responseJson = [
                'message' => 'Movie not found',
                'code' => Response::HTTP_NOT_FOUND
            ];

            return $this->json($responseJson, Response::HTTP_NOT_FOUND);
        }

        $user = $this->getUser();

        if (!$user) {
            $responseJson = [
                'message' => 'User not connected',
                'code' => Response::HTTP_UNAUTHORIZED
            ];

            return $this->json($responseJson, Response::HTTP_UNAUTHORIZED);
        }

        $commentToAdd = $serializer->deserialize($request->getContent(), Comment::class, 'json');
        $commentToAdd
            ->setCreatedAt(new DateTimeImmutable())
            ->setUser($this->getUser())
            ->setmovie($movieToAddToComment)
            ->setUser($user);
        $errors = $validator->validate($commentToAdd);
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

        $em->persist($commentToAdd);
        $em->flush();

        return $this->json($commentToAdd, Response::HTTP_OK, [], ['groups' => 'comments_add_response']);
    }

    /**
     * 
     * @Route("/api/movies/{slug}/comments/{id}/delete",requirements={"id":"\d+"},methods={"DELETE"})
     * @return Response
     */
    public function remove(string $slug, int $id, EntityManagerInterface $em, CommentRepository $commentRepository, MovieRepository $movieRepository): Response
    {
        $commentToDelete = $commentRepository->find($id);
        if (!$commentToDelete) {
            $jsonResponse = [
                'message' => 'This comment does not exist',
                'code' => Response::HTTP_NOT_FOUND
            ];
            return $this->json($jsonResponse, Response::HTTP_NOT_FOUND);
        }

        $movie = $movieRepository->findOneBySlug($slug);
        if (!$movie) {
            $jsonResponse = [
                'message' => 'The movie does not exist',
                'code' => Response::HTTP_NOT_FOUND
            ];
            return $this->json($jsonResponse, Response::HTTP_NOT_FOUND);
        }

        $movieComments = $movie->getComments();
        if (!$movieComments->contains($commentToDelete)) {
            $jsonResponse = [
                'message' => 'This comment is not related to the movie',
                'code' => Response::HTTP_BAD_REQUEST
            ];
            return $this->json($jsonResponse, Response::HTTP_BAD_REQUEST);
        }

        $user = $this->getUser();
        if(!$user){
            $jsonResponse = [
                'message'=>'User not connected',
                'code'=>Response::HTTP_UNAUTHORIZED
            ];
            return $this->json($jsonResponse,Response::HTTP_UNAUTHORIZED);
        }

        if($commentToDelete->getUser()!==$user){
            $jsonResponse = [
                'message'=>'This is not your comment',
                'code'=>Response::HTTP_FORBIDDEN
            ];
            return $this->json($jsonResponse,Response::HTTP_FORBIDDEN);
        }

        $em->remove($commentToDelete);
        $em->flush();
        return $this->json([], Response::HTTP_OK);
    }
}
