<?php

namespace App\Repository;

use App\Entity\Movie;
use App\Entity\Category;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;

/**
 * @method Movie|null find($id, $lockMode = null, $lockVersion = null)
 * @method Movie|null findOneBy(array $criteria, array $orderBy = null)
 * @method Movie[]    findAll()
 * @method Movie[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class MovieRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Movie::class);
    }

    /**
     * Get all movies of a category
     *
     * @param Category $category
     * @param integer|null $limit
     * @return array
     */
    public function findByCategory(Category $category, int $limit = null): array
    {
        return $this
            ->createQueryBuilder('m')
            ->join('m.categories', 'c')
            ->andWhere('c.id = :id')
            ->setParameter('id', $category->getId())
            ->setMaxResults($limit)
            ->getQuery()
            ->getResult();

    }
}
