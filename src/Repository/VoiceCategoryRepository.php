<?php

namespace Admin\Repository;

use Admin\Entity\VoiceCategory;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method VoiceCategory|null find($id, $lockMode = null, $lockVersion = null)
 * @method VoiceCategory|null findOneBy(array $criteria, array $orderBy = null)
 * @method VoiceCategory[]    findAll()
 * @method VoiceCategory[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class VoiceCategoryRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, VoiceCategory::class);
    }

//    /**
//     * @return VoiceCategory[] Returns an array of VoiceCategory objects
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
    public function findOneBySomeField($value): ?VoiceCategory
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
