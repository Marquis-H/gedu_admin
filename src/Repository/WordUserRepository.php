<?php

namespace Admin\Repository;

use Admin\Entity\WordUser;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method WordUser|null find($id, $lockMode = null, $lockVersion = null)
 * @method WordUser|null findOneBy(array $criteria, array $orderBy = null)
 * @method WordUser[]    findAll()
 * @method WordUser[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class WordUserRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, WordUser::class);
    }

//    /**
//     * @return WordUser[] Returns an array of WordUser objects
//     */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('w')
            ->andWhere('w.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('w.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?WordUser
    {
        return $this->createQueryBuilder('w')
            ->andWhere('w.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
