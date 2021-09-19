<?php

namespace App\Repository;

use App\Entity\SettingUserPreference;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method SettingUserPreference|null find($id, $lockMode = null, $lockVersion = null)
 * @method SettingUserPreference|null findOneBy(array $criteria, array $orderBy = null)
 * @method SettingUserPreference[]    findAll()
 * @method SettingUserPreference[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class SettingUserPreferenceRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, SettingUserPreference::class);
    }

    // /**
    //  * @return SettingUserPreference[] Returns an array of SettingUserPreference objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('s')
            ->andWhere('s.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('s.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */
    public function findUserPreference()
    {
        return $this->createQueryBuilder('s')
            ->andWhere('s.pseudo = :pseudo')
            ->setParameter('pseudo', 's')
            ->orderBy('s.id', 'ASC')
            ->setMaxResults(1)
            ->getQuery()
            ->getResult()
        ;
    }

    /*
    public function findOneBySomeField($value): ?SettingUserPreference
    {
        return $this->createQueryBuilder('s')
            ->andWhere('s.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
