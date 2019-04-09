<?php

namespace Admin\Repository;

use Admin\Entity\VoiceCategory;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method VoiceCategory|null find($id, $lockMode = null, $lockVersion = null)
 * @method VoiceCategory|null findOneBy(array $criteria, array $orderBy = null)
 * @method VoiceCategory[]    findAll()
 * @method VoiceCategory[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class VoiceCategoryRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, VoiceCategory::class);
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
			->andWhere('q.name = :name')
			->setParameters(['id' => $id, 'name' => $title])
			->getQuery()
			->getResult();

		return count($result);
	}
}
