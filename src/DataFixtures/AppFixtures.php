<?php

namespace App\DataFixtures;

use App\Entity\User;
use App\Repository\CategoryRepository;
use App\Repository\MovieRepository;
use App\Repository\ThematicRepository;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class AppFixtures extends Fixture
{
    private $passwordEncoder;
    private $thematicRepository;
    private $categoryRepository;
    private $movieRepository;

    public function __construct(UserPasswordHasherInterface $passwordEncoder, ThematicRepository $thematicRepository, CategoryRepository $categoryRepository, MovieRepository $movieRepository)
    {
        $this->passwordEncoder = $passwordEncoder;
        $this->thematicRepository = $thematicRepository;
        $this->categoryRepository = $categoryRepository;
        $this->movieRepository = $movieRepository;
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
            $users[mt_rand(0,4)]
                            ->addFavoriteMovie($allMovies[array_rand($allMovies)])
                            ->addFavoriteCategory($allCategories[array_rand($allCategories)])
                            ->addFavoriteThematic($allThematics[array_rand($allThematics)]);
        }
        $manager->flush();
    }
}
