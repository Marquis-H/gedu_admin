<?php

namespace Admin\Repository;

use Admin\Entity\WordUserLog;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method WordUserLog|null find($id, $lockMode = null, $lockVersion = null)
 * @method WordUserLog|null findOneBy(array $criteria, array $orderBy = null)
 * @method WordUserLog[]    findAll()
 * @method WordUserLog[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class WordUserLogRepository extends ServiceEntityRepository
{
	/**
	 * WordUserLogRepository constructor.
	 * @param RegistryInterface $registry
	 */
	public function __construct(RegistryInterface $registry)
	{
		parent::__construct($registry, WordUserLog::class);
	}

	/**
	 * @param $wordUserId
	 * @param $date
	 * @return mixed
	 * @throws \Doctrine\ORM\NonUniqueResultException
	 */
	public function findByDate($wordUserId, $date)
	{
		return $this->createQueryBuilder('q')
			->leftJoin('q.WordUser', 'w')
			->select('q')
			->where('w.id = :wordUserId')
			->andWhere('q.createdAt LIKE :createdAt')
			->setParameters([
				'wordUserId' => $wordUserId,
				'createdAt' => '%' . $date . '%'
			])
			->getQuery()
			->getOneOrNullResult();
	}

	/**
	 * @param $wordUserId
	 * @return mixed
	 * @throws \Doctrine\ORM\NonUniqueResultException
	 */
	public function findByLast($wordUserId)
	{
		return $this->createQueryBuilder('q')
			->leftJoin('q.WordUser', 'w')
			->select('q')
			->where('w.id = :wordUserId')
			->setParameters([
				'wordUserId' => $wordUserId,
			])
			->orderBy('q.createdAt', 'desc')
			->setMaxResults(1)
			->getQuery()
			->getOneOrNullResult();
	}
}
