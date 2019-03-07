<?php
/**
 * Created by PhpStorm.
 * User: marquis
 * Date: 2018/12/16
 * Time: 8:30 PM
 */

namespace Admin\Services;


use Admin\Entity\Page;
use Gedmo\Translatable\Entity\Repository\TranslationRepository;
use Symfony\Component\DependencyInjection\ContainerAwareTrait;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\PropertyAccess\PropertyAccess;

class PageService
{
	use ContainerAwareTrait;

	/**
	 * JWTEventListener constructor.
	 * @param ContainerInterface $container
	 */
	public function __construct(ContainerInterface $container)
	{
		$this->container = $container;
	}

	public function save(Page $page, $data)
	{
		$accessor = PropertyAccess::createPropertyAccessor();
		$em = $this->container->get('doctrine.orm.default_entity_manager');

		try {
			$onlineAt = $accessor->getValue($data, '[onlineAt]') ?
				new \DateTime($accessor->getValue($data, '[onlineAt]')) : null;
			$offlineAt = $accessor->getValue($data, '[offlineAt]') ?
				new \DateTime($accessor->getValue($data, '[offlineAt]')) : null;
			$page->setPath($accessor->getValue($data, '[path]'));
			$page->setOnlineAt($onlineAt);
			$page->setOfflineAt($offlineAt);
			$page->setBanner($accessor->getValue($data, '[banner]'));
			$page->setTitle($accessor->getValue($data, '[title]'));
			$page->setNavTitle($accessor->getValue($data, '[navTitle]'));
			$page->setOtherBanner($accessor->getValue($data, '[otherBanner]'));
			$page->setSummary($accessor->getValue($data, '[summary]'));
			$page->setContent($accessor->getValue($data, '[content]'));
			$page->setMetaTitle($accessor->getValue($data, '[metaTitle]'));
			$page->setKeywords($accessor->getValue($data, '[keywords]'));
			$page->setDescription($accessor->getValue($data, '[description]'));

			$em->persist($page);
			$em->flush();

			return $page;
		} catch (\Exception $e) {
			$em->rollback();

			throw new \LogicException();
		}
	}
}