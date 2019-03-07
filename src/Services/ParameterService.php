<?php
/**
 * Created by PhpStorm.
 * User: marquis
 * Date: 2018/10/25
 * Time: 11:54 AM
 */

namespace Admin\Services;

use Admin\Entity\BackendParameter;
use Psr\Container\ContainerInterface;
use Symfony\Component\DependencyInjection\ContainerAwareTrait;
use Symfony\Component\PropertyAccess\PropertyAccess;

/**
 * Class ParameterService
 * @package Admin\Services
 */
class ParameterService
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
	 * 保存设定
	 *
	 * @param $identify
	 * @param $data
	 * @return mixed
	 */
	public function save($identify, $data)
	{
		$em = $this->container->get('doctrine.orm.default_entity_manager');
		$parameterRepo = $em->getRepository('Admin:BackendParameter');

		try {
			foreach ($data as $k => $v) {
				$parameter = $parameterRepo->findOneBy(['identify' => $identify, 'ck' => $k]);
				if ($parameter) {
					$parameter->setParameter($v);
				} else {
					$parameter = new BackendParameter();
					$parameter->setIdentify($identify);
					$parameter->setCk($k);
					$parameter->setParameter($v);
				}

				$em->persist($parameter);
				$em->flush();

			}
		} catch (\Exception $e) {
			$em->rollback();

			throw new \LogicException();
		}

		return $data;
	}
}