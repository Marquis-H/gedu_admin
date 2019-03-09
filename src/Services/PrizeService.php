<?php
/**
 * Created by PhpStorm.
 * User: marquis
 * Date: 2019/2/12
 * Time: 5:06 PM
 */

namespace Admin\Services;


use Admin\Entity\Prize;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\PropertyAccess\PropertyAccess;

class PrizeService
{
	/** @var ContainerInterface */
	private $container;

	/**
	 * PrizeService constructor.
	 * @param ContainerInterface $container
	 */
	public function __construct(ContainerInterface $container)
	{
		$this->container = $container;
	}

	public function save(Prize $prize, $data)
	{
		$accessor = PropertyAccess::createPropertyAccessor();
		$em = $this->container->get('doctrine.orm.default_entity_manager');
		//$em->getConnection()->beginTransaction();
		$campusRepo = $em->getRepository('Admin:Campus');

		try {
			$prize->setTitle($accessor->getValue($data, '[title]'));
			$prize->setPhoto($accessor->getValue($data, '[photo]'));
			$prize->setIntegral($accessor->getValue($data, '[integral]'));
			$campusId = $accessor->getValue($data, '[campusId]');
			$campus = $campusRepo->findOneBy(['id' => $campusId]);
			$prize->setCampus($campus);

			$em->persist($prize);
			$em->flush();

			return $prize;
		} catch (\Exception $e) {
			$em->rollback();

			throw new \LogicException();
		}

	}
}