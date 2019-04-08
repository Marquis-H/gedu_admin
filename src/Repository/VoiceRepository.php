<?php

namespace Admin\Repository;

use Admin\Entity\Voice;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Voice|null find($id, $lockMode = null, $lockVersion = null)
 * @method Voice|null findOneBy(array $criteria, array $orderBy = null)
 * @method Voice[]    findAll()
 * @method Voice[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class VoiceRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Voice::class);
    }

//    /**
//     * @return Voice[] Returns an array of Voice objects
//     */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('v')
            ->andWhere('v.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('v.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Voice
    {
        return $this->createQueryBuilder('v')
            ->andWhere('v.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
