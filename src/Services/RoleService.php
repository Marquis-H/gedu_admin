<?php
/**
 * Created by PhpStorm.
 * User: marquis
 * Date: 2018/10/17
 * Time: 3:29 PM
 */

namespace Admin\Services;


use Admin\Entity\BackendRole;
use Psr\Container\ContainerInterface;
use Symfony\Component\DependencyInjection\ContainerAwareTrait;
use Symfony\Component\PropertyAccess\PropertyAccess;

/**
 * Class RoleService
 * @package Admin\Services
 */
class RoleService
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
	 * @param BackendRole $role
	 * @param $data
	 * @return BackendRole
	 */
	public function save(BackendRole $role, $data)
	{
		$accessor = PropertyAccess::createPropertyAccessor();
		$em = $this->container->get('doctrine.orm.default_entity_manager');

		try {
			$role->setRole($accessor->getValue($data, '[name]'));
			$role->setDescription($accessor->getValue($data, '[description]'));

			$em->persist($role);
			$em->flush();

			return $role;
		} catch (\Exception $e) {
			$em->rollback();

			throw new \LogicException();
		}
	}
}