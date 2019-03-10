<?php

namespace Admin\Repository;

use Admin\Entity\RewardLog;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method RewardLog|null find($id, $lockMode = null, $lockVersion = null)
 * @method RewardLog|null findOneBy(array $criteria, array $orderBy = null)
 * @method RewardLog[]    findAll()
 * @method RewardLog[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class RewardLogRepository extends ServiceEntityRepository
{
	/**
	 * RewardLogRepository constructor.
	 * @param RegistryInterface $registry
	 */
	public function __construct(RegistryInterface $registry)
	{
		parent::__construct($registry, RewardLog::class);
	}

	/**
	 * @param $day
	 * @param $infos
	 * @return mixed
	 */
	public function findLogByDay($day, $infos)
	{
		return $this->createQueryBuilder('q')
			->select('q.integral')
			->where('q.info IN (:infos)')
			->andWhere('q.createdAt = :day')
			->setParameters([
				'infos' => $infos,
				'day' => $day
			])
			->getQuery()
			->getResult();
	}
}
