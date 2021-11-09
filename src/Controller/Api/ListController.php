<?php

namespace App\Controller\Api;

use App\Entity\Movie;
use App\Normalizer\EntityNormalizer;
use App\Repository\MovieRepository;
use App\Utils\RunTimeFormatter;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

/**
 * @Route("/api/list")
 */
class ListController extends AbstractController
{
    /**
     * 
     * @Route("/add")
     * @return Response
     */
    public function addMovie(Request $request, MovieRepository $movieRepository, SerializerInterface $serializer, EntityManagerInterface $em)
    {
        $movieSlug = json_decode($request->getContent(), true)['movie'];
        $movieToAdd = $movieRepository->findOneBySlug($movieSlug);
        if (!$movieToAdd) {
            $jsonResponse = [
                'message' => 'Movie not found',
                'code' => Response::HTTP_BAD_REQUEST
            ];
            return $this->json($jsonResponse, Response::HTTP_BAD_REQUEST);
        }
        $user = $this->getUser();
        if (!$user) {
            $jsonResponse = [
                'message' => 'User not connected',
                'code' => Response::HTTP_UNAUTHORIZED
            ];

            return $this->json($jsonResponse, Response::HTTP_UNAUTHORIZED);
        }
        $usersFavoriteMovies = $user->getFavoriteMovies();
        if ($usersFavoriteMovies->contains($movieToAdd)) {
            $jsonResponse = [
                'message' => 'This movie is already on your favorite list',
                'code' => Response::HTTP_BAD_REQUEST
            ];
            return $this->json($jsonResponse, Response::HTTP_BAD_REQUEST);
        }
        $user->addFavoriteMovie($movieToAdd);
        $em->persist($user);
        $em->flush();
        return $this->json($movieToAdd, Response::HTTP_OK,[],['groups' => 'list_movie_add']);
    }
    /**
     * 
     * @Route("/delete/{slug}")
     * @return Response
     */
    public function removeMovie(string $slug, MovieRepository $movieRepository, EntityManagerInterface $em): Response
    {
        $movieToDelete = $movieRepository->findOneBySlug($slug);
        if (!$movieToDelete) {
            $jsonResponse = [
                'message' => 'Movie not found',
                'code' => Response::HTTP_BAD_REQUEST
            ];
            return $this->json($jsonResponse, Response::HTTP_BAD_REQUEST);
        }
        $user = $this->getUser();
        if (!$user) {
            $jsonResponse = [
                'message' => 'User not connected',
                'code' => Response::HTTP_UNAUTHORIZED
            ];
            return $this->json($jsonResponse, Response::HTTP_UNAUTHORIZED);
        }
        $usersFavoriteMovies = $user->getFavoriteMovies();
        if (!$usersFavoriteMovies->contains($movieToDelete)) {
            $jsonResponse = [
                'message' => 'This movie is not on your favorite list',
                'code' => Response::HTTP_BAD_REQUEST
            ];
            return $this->json($jsonResponse, Response::HTTP_BAD_REQUEST);
        }
        $user->removeFavoriteMovie($movieToDelete);
        $em->flush();
        $jsonResponse = [
            'code' => Response::HTTP_NO_CONTENT
        ];
        return $this->json($jsonResponse, Response::HTTP_NO_CONTENT);
    }

    /**

     * @Route("/")
     * @return Response
     */
    public function show(): Response
    {
        $user = $this->getUser();
        if (!$user) {
            $jsonResponse = [
                'message' => 'user not connected',
                'code' => Response::HTTP_UNAUTHORIZED
            ];

            return $this->json($jsonResponse, Response::HTTP_UNAUTHORIZED);
        }

        $userFavoriteMovies = $user->getFavoriteMovies();

        return $this->json($userFavoriteMovies, Response::HTTP_OK, [], ['groups' => "list_movie_show"]);
    }
}
