<?php

namespace Admin\Repository;

use Admin\Entity\BackendGroup;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method BackendGroup|null find($id, $lockMode = null, $lockVersion = null)
 * @method BackendGroup|null findOneBy(array $criteria, array $orderBy = null)
 * @method BackendGroup[]    findAll()
 * @method BackendGroup[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class BackendGroupRepository extends ServiceEntityRepository
{
	public function __construct(RegistryInterface $registry)
	{
		parent::__construct($registry, BackendGroup::class);
	}

	/**
	 * 检查名称重复
	 *
	 * @param $name
	 * @param $id
	 * @return int
	 */
	public function isUnique($name, $id)
	{
		$result = $this->createQueryBuilder('q')
			->select('q')
			->where('q.id != :id')
			->andWhere('q.name = :name')
			->setParameters(['id' => $id, 'name' => $name])
			->getQuery()
			->getResult();

		return count($result);
	}
}
