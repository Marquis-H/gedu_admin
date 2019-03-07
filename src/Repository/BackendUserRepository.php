<?php

namespace Admin\Repository;

use Admin\Entity\BackendUser;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method BackendUser|null find($id, $lockMode = null, $lockVersion = null)
 * @method BackendUser|null findOneBy(array $criteria, array $orderBy = null)
 * @method BackendUser[]    findAll()
 * @method BackendUser[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class BackendUserRepository extends ServiceEntityRepository
{
	/**
	 * BackendUserRepository constructor.
	 * @param RegistryInterface $registry
	 */
	public function __construct(RegistryInterface $registry)
	{
		parent::__construct($registry, BackendUser::class);
	}

	/**
	 * 检查是否有重复用户名
	 *
	 * @param $username
	 * @param $id
	 * @return int
	 */
	public function isUnique($username, $id)
	{
		$result = $this->createQueryBuilder('q')
			->select('q')
			->where('q.id != :id')
			->andWhere('q.username = :username')
			->setParameters(['id' => $id, 'username' => $username])
			->getQuery()
			->getResult();

		return count($result);
	}
}
