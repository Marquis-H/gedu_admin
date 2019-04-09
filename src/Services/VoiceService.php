<?php
/**
 * Created by PhpStorm.
 * User: marquis
 * Date: 2019/4/9
 * Time: 9:52 PM
 */

namespace Admin\Services;


use Admin\Entity\Voice;
use Admin\Entity\VoiceCategory;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\PropertyAccess\PropertyAccess;

/**
 * Class VoiceService
 * @package Admin\Services
 */
class VoiceService
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
	 * 保存音频分类
	 *
	 * @param VoiceCategory $cat
	 * @param $data
	 * @return VoiceCategory
	 */
	public function saveCat(VoiceCategory $cat, $data)
	{
		$accessor = PropertyAccess::createPropertyAccessor();
		$em = $this->container->get('doctrine.orm.default_entity_manager');

		try {
			$cat->setName($accessor->getValue($data, '[title]'));

			$em->persist($cat);
			$em->flush();

			return $cat;
		} catch (\Exception $e) {
			$em->rollback();

			throw new \LogicException();
		}
	}

	/**
	 * 保存音频
	 *
	 * @param Voice $voice
	 * @param $data
	 * @return Voice
	 */
	public function save(Voice $voice, $data)
	{
		$em = $this->container->get('doctrine.orm.default_entity_manager');
		$accessor = PropertyAccess::createPropertyAccessor();

		try {
			$voice->setName($accessor->getValue($data, '[name]'));
			$voice->setUrl($accessor->getValue($data, '[url]'));
			$voice->setTab($accessor->getValue($data, '[tav]'));

			//保存校区
			$voiceCatId = $accessor->getValue($data, '[catId]');
			$voiceCat = $em->getRepository('Admin:VoiceCategory')->findOneBy(['id' => $voiceCatId]);
			$voice->setVoiceCategory($voiceCat);
			$em->persist($voice);
			$em->flush();

			return $voice;
		} catch (\Exception $e) {
			$em->rollback();

			throw new \LogicException();
		}
	}
}