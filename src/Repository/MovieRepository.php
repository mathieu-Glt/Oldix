<?php

namespace App\Repository;

use App\Entity\Movie;
use App\Entity\Category;
use App\Entity\Thematic;
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
            ->orderBy('m.name', 'ASC')
            ->setMaxResults($limit)
            ->getQuery()
            ->getResult();
    }

    /**
     * Get all movies of a thematic
     *
     * @param Thematic $thematic
     * @param integer|null $limit
     * @return array
     */
    public function findByThematic(Thematic $thematic, int $limit = null): array
    {
        return $this
            ->createQueryBuilder('m')
            ->join('m.thematics', 't')
            ->andWhere('t.id = :id')
            ->setParameter('id', $thematic->getId())
            ->orderBy('m.name', 'ASC')
            ->setMaxResults($limit)
            ->getQuery()
            ->getResult();
    }

    /**
     * Get movies or a movie by a query
     *
     * @param string $query
     * @return array
     */
    public function findByQuery(string $query): array
    {
        return $this
            ->createQueryBuilder('m')
            ->andWhere('m.name LIKE :query')
            ->setParameter(':query', '%' . $query . '%')
            ->getQuery()
            ->getResult();
    }


    /**
     * Get movies or a movie by a query
     *
     * @param string $query
     * @return array
     */
    public function findHitchcock(): array
    {
        return $this
            ->createQueryBuilder('m')
            ->andWhere('m.realisator LIKE :realisator')
            ->setParameter("realisator", "Alfred Hitchcock")
            ->getQuery()
            ->getResult();
    }

    /**
     * Get movies or a movie by a query
     *
     * @param string $query
     * @return array
     */
    public function findFritzLang(): array
    {
        return $this
            ->createQueryBuilder('m')
            ->andWhere('m.realisator LIKE :realisator')
            ->setParameter("realisator", "Fritz Lang")
            ->getQuery()
            ->getResult();
    }

    /**

     * Get the top ten movies
     *
     * @param string $query
     * @return array
     */
    public function findTopTen()
    {
        return $this->createQueryBuilder('m')
        ->orderBy('m.averageRate', 'DESC')
        ->setMaxResults(10)
        ->getQuery()
        ->getResult();
    }

    /**
     * Find all movies by tenties
     * 
     * @param mixed $name
     * @return array
     */
    public function findMoviesByTenties():array
    {
        return $this
        ->createQueryBuilder('m')
                    ->where('m.releasedDate BETWEEN :start AND :end')
                    ->setParameter('start', 1910)
                    ->setParameter('end', 1919)
                    ->orderBy('m.releasedDate', 'ASC')
                    ->getQuery()
                    ->getResult();
    }



    /**
     * Find all movies by twenties
     * 
     * @param mixed $name
     * @return array
     */
    public function findMoviesByTwenties():array
    {
        return $this
        ->createQueryBuilder('m')
                    ->where('m.releasedDate BETWEEN :start AND :end')
                    ->setParameter('start', 1920)
                    ->setParameter('end', 1929)
                    ->orderBy('m.releasedDate', 'ASC')
                    ->getQuery()
                    ->getResult();
    }




    /**
     * Find all movies by thirties
     * 
     * @param mixed $name
     * @return array
     */
    public function findMoviesByThirties():array
    {
        return $this
        ->createQueryBuilder('m')
                    ->where('m.releasedDate BETWEEN :start AND :end')
                    ->setParameter('start', 1930)
                    ->setParameter('end', 1939)
                    ->orderBy('m.releasedDate', 'ASC')
                    ->getQuery()
                    ->getResult();
    }

    /**
     * Find all movies by forties
     * 
     * @param mixed $name
     * @return array
     */
    public function findMoviesByForties():array
    {
        return $this
        ->createQueryBuilder('m')
                    ->where('m.releasedDate BETWEEN :start AND :end')
                    ->setParameter('start', 1940)
                    ->setParameter('end', 1949)
                    ->orderBy('m.releasedDate', 'ASC')
                    ->getQuery()
                    ->getResult();
    }

    /**
     * Find all movies by fifties
     * 
     * @param mixed $name
     * @return array
     */
    public function findMoviesByFifties():array
    {
        return $this
        ->createQueryBuilder('m')
                    ->where('m.releasedDate BETWEEN :start AND :end')
                    ->setParameter('start', 1950)
                    ->setParameter('end', 1959)
                    ->orderBy('m.releasedDate', 'ASC')
                    ->getQuery()
                    ->getResult();
    }

    /**
     * Find all movies by sixties
     * 
     * @param mixed $name
     * @return array
     */
    public function findMoviesBySixties():array
    {
        return $this
        ->createQueryBuilder('m')
                    ->where('m.releasedDate BETWEEN :start AND :end')
                    ->setParameter('start', 1960)
                    ->setParameter('end', 1969)
                    ->orderBy('m.releasedDate', 'ASC')
                    ->getQuery()
                    ->getResult();
    }

    /**
     * Find all movies by seventies
     * 
     * @param mixed $name
     * @return array
     */
    public function findMoviesBySeventies():array
    {
        return $this
        ->createQueryBuilder('m')
                    ->where('m.releasedDate BETWEEN :start AND :end')
                    ->setParameter('start', 1970)
                    ->setParameter('end', 1979)
                    ->orderBy('m.releasedDate', 'ASC')
                    ->getQuery()
                    ->getResult();
    }

    /**
     * Find all movies by eighties
     * 
     * @param mixed $name
     * @return array
     */
    public function findMoviesByEighties():array
    {
        return $this
        ->createQueryBuilder('m')
                    ->where('m.releasedDate BETWEEN :start AND :end')
                    ->setParameter('start', 1980)
                    ->setParameter('end', 1989)
                    ->orderBy('m.releasedDate', 'ASC')
                    ->getQuery()
                    ->getResult();
    }

    public function findByCategories(array $categoryId): array
    {
        return $this
            ->createQueryBuilder('m')
            ->join('m.categories', 'c')
            ->andWhere('c.id IN (' . implode(',', $categoryId) . ')')
            ->getQuery()
            ->getResult();
    }
}
