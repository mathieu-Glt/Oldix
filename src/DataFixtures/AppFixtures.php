<?php

namespace App\DataFixtures;

use App\Entity\Rate;
use App\Entity\User;
use DateTimeImmutable;
use App\Entity\Comment;
use App\Repository\MovieRepository;
use App\Repository\CategoryRepository;
use App\Repository\ThematicRepository;
use App\Utils\AverageRateCalculator;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class AppFixtures extends Fixture
{
    private $passwordEncoder;
    private $thematicRepository;
    private $categoryRepository;
    private $movieRepository;
    private $averageRateCalculator;

    public function __construct(UserPasswordHasherInterface $passwordEncoder, ThematicRepository $thematicRepository, CategoryRepository $categoryRepository, MovieRepository $movieRepository,AverageRateCalculator $averageRateCalculator)
    {
        $this->passwordEncoder = $passwordEncoder;
        $this->thematicRepository = $thematicRepository;
        $this->categoryRepository = $categoryRepository;
        $this->movieRepository = $movieRepository;
        $this->averageRateCalculator = $averageRateCalculator;
    }
    public function load(ObjectManager $manager): void
    {
        $users = [];
        $userEmail = ['AlexandreR@gmail.com', 'MathieuD@gmail.com', 'CorentinW@gmail.com', 'ThomasM@gmail.com', 'MathieuG@gmail.com'];

        foreach ($userEmail as $userEmail) {
            $user = new User();
            $user
                ->setEmail($userEmail)
                ->setPassword($this->passwordEncoder->hashPassword($user, 'demo'))
                ->setRoles(['ROLE_USER']);
            $manager->persist($user);
            $users[] = $user;
        }

        $allMovies = $this->movieRepository->findAll();
        $allCategories = $this->categoryRepository->findAll();
        $allThematics = $this->thematicRepository->findAll();
        for ($i = 0; $i < 20; $i++) {
            $users[mt_rand(0, 4)]
                ->addFavoriteMovie($allMovies[array_rand($allMovies)])
                ->addFavoriteCategory($allCategories[array_rand($allCategories)])
                ->addFavoriteThematic($allThematics[array_rand($allThematics)]);
        }
        for ($i = 1; $i < 201; $i++) {
            $comment = new Comment();
            $comment
                ->setMovie($allMovies[array_rand($allMovies)])
                ->setUser($users[mt_rand(0, 4)])
                ->setCreatedAt(new DateTimeImmutable())
                ->setComment('comment number ' . $i);
            $manager->persist($comment);
        }
        for ($i = 1; $i <601; $i++) {
            $rate = new Rate();
            $rate
                ->setUser($users[mt_rand(0, 4)])
                ->setScore(mt_rand(0, 5))
                ->setMovie($allMovies[array_rand($allMovies)]);
            $manager->persist($rate);
            $manager->flush();
        }
        foreach($allMovies as $movie){
            $movie->setAverageRate($this->averageRateCalculator->calculate($movie->getRates()));
        }
        $manager->flush();
    }
}

