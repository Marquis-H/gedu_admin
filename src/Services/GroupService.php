<?php
/**
 * Created by PhpStorm.
 * User: marquis
 * Date: 2018/10/20
 * Time: 1:23 PM
 */

namespace Admin\Services;


use Admin\Entity\BackendGroup;
use Symfony\Component\DependencyInjection\ContainerAwareTrait;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\PropertyAccess\PropertyAccess;

class GroupService
{
	use ContainerAwareTrait;

	/**
	 * RoleService constructor.
	 * @param ContainerInterface $container
	 */
	public function __construct(ContainerInterface $container)
	{
		$this->container = $container;
	}

	/**
	 * 保存
	 *
	 * @param BackendGroup $group
	 * @param $data
	 * @return BackendGroup
	 */
	public function save(BackendGroup $group, $data)
	{
		$accessor = PropertyAccess::createPropertyAccessor();
		$em = $this->container->get('doctrine.orm.default_entity_manager');

		try {
			$group->setName($accessor->getValue($data, '[name]'));
			$group->setDescription($accessor->getValue($data, '[description]'));
			$group->setRoles([]); // TODO 默认不做权限

			$em->persist($group);
			$em->flush();

			return $group;
		} catch (\Exception $e) {
			$em->rollback();

			throw new \LogicException();
		}
	}
}