<?php

namespace App\Repository;

use App\Entity\ActualityComment;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method ActualityComment|null find($id, $lockMode = null, $lockVersion = null)
 * @method ActualityComment|null findOneBy(array $criteria, array $orderBy = null)
 * @method ActualityComment[]    findAll()
 * @method ActualityComment[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ActualityCommentRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ActualityComment::class);
    }

    // /**
    //  * @return ActualityComment[] Returns an array of ActualityComment objects
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
    public function findOneBySomeField($value): ?ActualityComment
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
