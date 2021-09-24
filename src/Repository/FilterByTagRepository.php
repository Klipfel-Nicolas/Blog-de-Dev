<?php

namespace App\Repository;

use App\Entity\FilterByTag;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method FilterByTag|null find($id, $lockMode = null, $lockVersion = null)
 * @method FilterByTag|null findOneBy(array $criteria, array $orderBy = null)
 * @method FilterByTag[]    findAll()
 * @method FilterByTag[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class FilterByTagRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, FilterByTag::class);
    }

    // /**
    //  * @return FilterByTag[] Returns an array of FilterByTag objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('f')
            ->andWhere('f.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('f.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?FilterByTag
    {
        return $this->createQueryBuilder('f')
            ->andWhere('f.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
