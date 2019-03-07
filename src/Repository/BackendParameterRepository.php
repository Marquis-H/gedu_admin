<?php

namespace Admin\Repository;

use Admin\Entity\BackendParameter;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method BackendParameter|null find($id, $lockMode = null, $lockVersion = null)
 * @method BackendParameter|null findOneBy(array $criteria, array $orderBy = null)
 * @method BackendParameter[]    findAll()
 * @method BackendParameter[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class BackendParameterRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, BackendParameter::class);
    }

//    /**
//     * @return Parameter[] Returns an array of Parameter objects
//     */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('p.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Parameter
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
