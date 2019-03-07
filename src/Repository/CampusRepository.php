<?php

namespace Admin\Repository;

use Admin\Entity\Campus;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Campus|null find($id, $lockMode = null, $lockVersion = null)
 * @method Campus|null findOneBy(array $criteria, array $orderBy = null)
 * @method Campus[]    findAll()
 * @method Campus[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CampusRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Campus::class);
    }

	/**
	 * 检查名称重复
	 *
	 * @param $title
	 * @param $id
	 * @return int
	 */
	public function isUnique($title, $id)
	{
		$result = $this->createQueryBuilder('q')
			->select('q')
			->where('q.id != :id')
			->andWhere('q.title = :title')
			->setParameters(['id' => $id, 'title' => $title])
			->getQuery()
			->getResult();

		return count($result);
	}
}
