<?php

namespace Admin\Repository;

use Admin\Entity\BackendRole;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method BackendRole|null find($id, $lockMode = null, $lockVersion = null)
 * @method BackendRole|null findOneBy(array $criteria, array $orderBy = null)
 * @method BackendRole[]    findAll()
 * @method BackendRole[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class BackendRoleRepository extends ServiceEntityRepository
{
	/**
	 * BackendRoleRepository constructor.
	 * @param RegistryInterface $registry
	 */
	public function __construct(RegistryInterface $registry)
	{
		parent::__construct($registry, BackendRole::class);
	}

	/**
	 * 检查名称重复
	 *
	 * @param $role
	 * @param $id
	 * @return int
	 */
	public function isUnique($role, $id)
	{
		$result = $this->createQueryBuilder('q')
			->select('q')
			->where('q.id != :id')
			->andWhere('q.role = :role')
			->setParameters(['id' => $id, 'role' => $role])
			->getQuery()
			->getResult();

		return count($result);
	}
}
