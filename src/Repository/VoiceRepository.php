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
	/**
	 * VoiceRepository constructor.
	 * @param RegistryInterface $registry
	 */
	public function __construct(RegistryInterface $registry)
	{
		parent::__construct($registry, Voice::class);
	}

	/**
	 * @return mixed
	 */
	public function findByCat()
	{
		return $this->createQueryBuilder('q')
			->select('q')
			->leftJoin('q.VoiceCategory', 'v')
			->orderBy('v.id', 'asc')
			->orderBy('q.id', 'asc')
			->getQuery()
			->getResult();
	}
}
