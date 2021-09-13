<?php

namespace App\Repository;

use App\Entity\ActualityNews;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method ActualityNews|null find($id, $lockMode = null, $lockVersion = null)
 * @method ActualityNews|null findOneBy(array $criteria, array $orderBy = null)
 * @method ActualityNews[]    findAll()
 * @method ActualityNews[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ActualityNewsRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ActualityNews::class);
    }

    // /**
    //  * @return ActualityNews[] Returns an array of ActualityNews objects
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
    public function findOneBySomeField($value): ?ActualityNews
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
