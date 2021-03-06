<?php

namespace App\Repository;

use App\Entity\TopicComment;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method TopicComment|null find($id, $lockMode = null, $lockVersion = null)
 * @method TopicComment|null findOneBy(array $criteria, array $orderBy = null)
 * @method TopicComment[]    findAll()
 * @method TopicComment[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TopicCommentRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, TopicComment::class);
    }

    // /**
    //  * @return TopicComment[] Returns an array of TopicComment objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('t')
            ->andWhere('t.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('t.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?TopicComment
    {
        return $this->createQueryBuilder('t')
            ->andWhere('t.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
