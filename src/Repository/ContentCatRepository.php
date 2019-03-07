<?php

namespace Admin\Repository;

use Admin\Entity\ContentCat;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method ContentCat|null find($id, $lockMode = null, $lockVersion = null)
 * @method ContentCat|null findOneBy(array $criteria, array $orderBy = null)
 * @method ContentCat[]    findAll()
 * @method ContentCat[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ContentCatRepository extends ServiceEntityRepository
{
	public function __construct(RegistryInterface $registry)
	{
		parent::__construct($registry, ContentCat::class);
	}

	/**
	 * 检查是否有重复
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
