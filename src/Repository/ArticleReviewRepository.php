<?php

namespace App\Repository;

use App\Entity\ArticleReview;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method ArticleReview|null find($id, $lockMode = null, $lockVersion = null)
 * @method ArticleReview|null findOneBy(array $criteria, array $orderBy = null)
 * @method ArticleReview[]    findAll()
 * @method ArticleReview[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ArticleReviewRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ArticleReview::class);
    }

    // /**
    //  * @return ArticleReview[] Returns an array of ArticleReview objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('a')
            ->andWhere('a.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('a.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?ArticleReview
    {
        return $this->createQueryBuilder('a')
            ->andWhere('a.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
