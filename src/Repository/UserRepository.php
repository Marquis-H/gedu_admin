<?php

namespace Admin\Repository;

use Admin\Entity\User;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method User|null find($id, $lockMode = null, $lockVersion = null)
 * @method User|null findOneBy(array $criteria, array $orderBy = null)
 * @method User[]    findAll()
 * @method User[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class UserRepository extends ServiceEntityRepository
{
	/**
	 * UserRepository constructor.
	 * @param RegistryInterface $registry
	 */
	public function __construct(RegistryInterface $registry)
	{
		parent::__construct($registry, User::class);
	}

	/**
	 * @param $phone
	 * @param $id
	 * @return int
	 */
	public function isUnique($phone, $id)
	{
		$result = $this->createQueryBuilder('q')
			->select('q')
			->where('q.phone = :phone')
			->andWhere('q.id != :id')
			->setParameters([
				'id' => $id,
				'phone' => $phone
			])
			->getQuery()
			->getResult();

		return count($result);
	}
}
