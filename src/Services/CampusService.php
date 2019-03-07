<?php
/**
 * Created by PhpStorm.
 * User: marquis
 * Date: 2019/1/31
 * Time: 11:01 AM
 */

namespace Admin\Services;


use Admin\Entity\Campus;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\PropertyAccess\PropertyAccess;

class CampusService
{
	/**
	 * @var ContainerInterface
	 */
	private $container;

	/**
	 * CampusService constructor.
	 * @param ContainerInterface $container
	 */
	public function __construct(ContainerInterface $container)
	{
		$this->container = $container;
	}

	public function save(Campus $campus, $data)
	{
		$accessor = PropertyAccess::createPropertyAccessor();
		$em = $this->container->get('doctrine.orm.default_entity_manager');

		try {
			$campus->setTitle($accessor->getValue($data, '[title]'));
			$campus->setInfomation($accessor->getValue($data, '[infomation]'));

			$em->persist($campus);
			$em->flush();

			return $campus;
		} catch (\Exception $e) {
			$em->rollback();

			throw new \LogicException();
		}
	}
}