<?php

namespace App\Controller\Api;

use App\Entity\Rate;
use App\Repository\MovieRepository;
use App\Repository\RateRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class RateController extends AbstractController
{
    /**
     * 
     * @Route("/api/movies/{slug}/rates/add",methods={"POST"})
     * @return Response
     */
    public function add(string $slug, MovieRepository $movieRepository, SerializerInterface $serializer, Request $request, EntityManagerInterface $em, ValidatorInterface $validator): Response
    {
        $movie = $movieRepository->findOneBySlug($slug);
        if (!$movie) {
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

        $rateToAdd = $serializer->deserialize($request->getContent(), Rate::class, 'json');
        $rateToAdd->setMovie($movie);
        $errors = $validator->validate($rateToAdd);
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
        $em->persist($rateToAdd);
        $em->flush();
        return $this->json([$rateToAdd], Response::HTTP_OK);
    }

    /**
     * 
     * @Route("/api/movies/{slug}/rates/{id}/delete",methods={"DELETE"})
     * @return Response
     */
    public function remove(string $slug, int $id, MovieRepository $movieRepository, RateRepository $rateRepository, EntityManagerInterface $em)
    {
        //TODO check if rate exists
        $rateToDelete = $rateRepository->find($id);
        if (!$rateToDelete) {
            $responseJson = [
                'message' => 'Rate not found',
                'code' => Response::HTTP_NOT_FOUND
            ];
            return $this->json($responseJson, Response::HTTP_NOT_FOUND);
        }
        //TODO check if movie exists
        $movie = $movieRepository->findOneBySlug($slug);
        if (!$movie) {
            $responseJson = [
                'message' => 'Movie not found',
                'code' => Response::HTTP_NOT_FOUND
            ];
            return $this->json($responseJson, Response::HTTP_NOT_FOUND);
        }
        //TODO check if rate is related to the movie
        if (!$movie->getRates()->contains($rateToDelete)) {
            $responseJson = [
                'message' => 'The rate is not related to the movie',
                'code' => Response::HTTP_BAD_REQUEST
            ];
            return $this->json($responseJson, Response::HTTP_BAD_REQUEST);
        }
        //TODO check if user is connected
        $user = $this->getUser();
        if (!$user) {
            $responseJson = [
                'message' => 'User not connected',
                'code' => Response::HTTP_UNAUTHORIZED
            ];
            return $this->json($responseJson, Response::HTTP_UNAUTHORIZED);
        }
        //TODO check if user has created the rate

        //TODO ok
        $movie->removeRate($rateToDelete);
        $em->flush();
        return $this->json([], Response::HTTP_OK);
    }
}
