<?php

namespace Admin\Repository;

use Admin\Entity\Content;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Content|null find($id, $lockMode = null, $lockVersion = null)
 * @method Content|null findOneBy(array $criteria, array $orderBy = null)
 * @method Content[]    findAll()
 * @method Content[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ContentRepository extends ServiceEntityRepository
{
	public function __construct(RegistryInterface $registry)
	{
		parent::__construct($registry, Content::class);
	}

	public function findByCat($catId)
	{
		return $this->createQueryBuilder('q')
			->select('q')
			->leftJoin('q.ContentCat', 'c')
			->where('c.id = :catId')
			->setParameter('catId', $catId)
			->getQuery()
			->getResult();
	}
}
