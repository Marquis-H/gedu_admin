<?php

namespace Admin\Repository;

use Admin\Entity\Word;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Word|null find($id, $lockMode = null, $lockVersion = null)
 * @method Word|null findOneBy(array $criteria, array $orderBy = null)
 * @method Word[]    findAll()
 * @method Word[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class WordRepository extends ServiceEntityRepository
{
	/**
	 * WordRepository constructor.
	 * @param RegistryInterface $registry
	 */
	public function __construct(RegistryInterface $registry)
	{
		parent::__construct($registry, Word::class);
	}

	/**
	 * 获取同一类型的单词
	 *
	 * @param $type
	 * @return array
	 */
	public function findByType($type)
	{
		return $this->createQueryBuilder('q')
			->select('q.word')
			->where('q.tabs like :tab')
			->setParameter('tab', '%' . $type . '%')
			->getQuery()
			->getArrayResult();
	}
}
