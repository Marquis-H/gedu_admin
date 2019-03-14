<?php
/**
 * Created by PhpStorm.
 * User: marquis
 * Date: 2019/2/8
 * Time: 2:33 PM
 */

namespace Admin\Services;


use Admin\Entity\Banner;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\PropertyAccess\PropertyAccess;

class BannerService
{
	/** @var ContainerInterface */
	private $container;

	/**
	 * BannerService constructor.
	 * @param ContainerInterface $container
	 */
	public function __construct(ContainerInterface $container)
	{
		$this->container = $container;
	}

	public function save(Banner $banner, $data)
	{
		$em = $this->container->get('doctrine.orm.default_entity_manager');
		$accessor = PropertyAccess::createPropertyAccessor();

		try {
			$banner->setPhoto($accessor->getValue($data, '[photo]'));
			$onlineAt = $accessor->getValue($data, '[onlineAt]') ?
				new \DateTime($accessor->getValue($data, '[onlineAt]')) : null;
			$offlineAt = $accessor->getValue($data, '[offlineAt]') ?
				new \DateTime($accessor->getValue($data, '[offlineAt]')) : null;
			$banner->setOnlineAt($onlineAt);
			$banner->setOfflineAt($offlineAt);
			$banner->setPosition($accessor->getValue($data, '[position]'));
			$banner->setSlug($accessor->getValue($data, '[slug]'));
			//保存校区
			$campusId = $accessor->getValue($data, '[campusId]');
			$campus = $em->getRepository('Admin:Campus')->findOneBy(['id' => $campusId]);
			$banner->setCampus($campus);
			$em->persist($banner);
			$em->flush();

			return $banner;
		} catch (\Exception $e) {
			$em->rollback();

			throw new \LogicException();
		}
	}
}