<?php

namespace Admin\Repository;

use Admin\Entity\WechatBinding;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method WechatBinding|null find($id, $lockMode = null, $lockVersion = null)
 * @method WechatBinding|null findOneBy(array $criteria, array $orderBy = null)
 * @method WechatBinding[]    findAll()
 * @method WechatBinding[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class WechatBindingRepository extends ServiceEntityRepository
{
	/**
	 * WechatBindingRepository constructor.
	 * @param RegistryInterface $registry
	 */
	public function __construct(RegistryInterface $registry)
	{
		parent::__construct($registry, WechatBinding::class);
	}

	/**
	 * @param $openId
	 * @return mixed
	 */
	public function findPhoneByOpenId($openId)
	{
		return $this->createQueryBuilder('q')
			->leftJoin('q.User', 'u')
			->select('u.phone')
			->where('q.openid = :openid')
			->setParameter('openid', $openId)
			->getQuery()
			->getResult();
	}

	/**
	 * @param $openId
	 * @return mixed
	 * @throws \Doctrine\ORM\NonUniqueResultException
	 */
	public function findUserByOpenId($openId)
	{
		return $this->createQueryBuilder('q')
			->leftJoin('q.User', 'u')
			->select('q, u')
			->where('q.openid = :openid')
			->setParameter('openid', $openId)
			->getQuery()
			->getOneOrNullResult();
	}
}
