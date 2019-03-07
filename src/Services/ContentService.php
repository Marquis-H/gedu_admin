<?php
/**
 * Created by PhpStorm.
 * User: marquis
 * Date: 2019/2/11
 * Time: 4:34 PM
 */

namespace Admin\Services;


use Admin\Entity\Content;
use Admin\Entity\ContentCat;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\PropertyAccess\PropertyAccess;

/**
 * Class ContentService
 * @package Admin\Services
 */
class ContentService
{
	/** @var ContainerInterface */
	private $container;

	/**
	 * ContentService constructor.
	 * @param ContainerInterface $container
	 */
	public function __construct(ContainerInterface $container)
	{
		$this->container = $container;
	}

	/**
	 * 保存内容分类
	 *
	 * @param ContentCat $cat
	 * @param $data
	 * @return ContentCat
	 */
	public function saveCat(ContentCat $cat, $data)
	{
		$accessor = PropertyAccess::createPropertyAccessor();
		$em = $this->container->get('doctrine.orm.default_entity_manager');

		try {
			$cat->setTitle($accessor->getValue($data, '[title]'));
			$cat->setSlug($accessor->getValue($data, '[slug]'));

			$em->persist($cat);
			$em->flush();

			return $cat;
		} catch (\Exception $e) {
			$em->rollback();

			throw new \LogicException();
		}
	}

	/**
	 * 保存内容
	 *
	 * @param Content $content
	 * @param $data
	 * @return Content
	 */
	public function save(Content $content, $data)
	{
		$accessor = PropertyAccess::createPropertyAccessor();
		$em = $this->container->get('doctrine.orm.default_entity_manager');
		$contentCatRepo = $em->getRepository('Admin:ContentCat');
		$campusRepo = $em->getRepository('Admin:Campus');

		try {
			$content->setPhoto($accessor->getValue($data, '[photo]'));
			$content->setTitle($accessor->getValue($data, '[title]'));
			$content->setSummary($accessor->getValue($data, '[summary]'));
			$content->setContent($accessor->getValue($data, '[content]'));
			$content->setExtra($accessor->getValue($data, '[extra]'));
			$catId = $accessor->getValue($data, '[catId]');
			$contentCat = $contentCatRepo->findOneBy(['id' => $catId]);
			$content->setContentCat($contentCat);
			$campusId = $accessor->getValue($data, '[campusId]');
			$campus = $campusRepo->findOneBy(['id' => $campusId]);
			$content->setCampus($campus);

			$em->persist($content);
			$em->flush();

			return $content;
		} catch (\Exception $e) {
			$em->rollback();

			throw new \LogicException();
		}
	}
}