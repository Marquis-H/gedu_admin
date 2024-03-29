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
	 * @param $isNew
	 * @return Voice
	 */
	public function save(Voice $voice, $data, $isNew = false)
	{
		$em = $this->container->get('doctrine.orm.default_entity_manager');
		$accessor = PropertyAccess::createPropertyAccessor();

		try {
			$voice->setName($accessor->getValue($data, '[name]'));
			$voice->setUrl($accessor->getValue($data, '[url]'));
			$voice->setTab($accessor->getValue($data, '[tab]'));
			$translation = $accessor->getValue($data, '[translation]');
			if ($isNew) {
				$voice->setTranslation($translation ? [
					[
						'cntext' => '',
						'entext' => $translation,
						'start' => '',
						'end' => ''
					]
				] : []);
			} else {
				if (empty($voice->getTranslation()) && $translation && $translation != 'a:0:{}') {
					$voice->setTranslation([
						[
							'cntext' => '',
							'entext' => $translation,
							'start' => '',
							'end' => ''
						]
					]);
				} else if (!$translation) {
					$voice->setTranslation([]);
				} else {
					$voice->setTranslation(unserialize($translation));
				}
			}

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

	/**
	 * @return array
	 */
	public function getList()
	{
		$accessor = PropertyAccess::createPropertyAccessor();
		$em = $this->container->get('doctrine.orm.default_entity_manager');
		$cats = $em->getRepository('Admin:VoiceCategory')->createQueryBuilder('q')
			->select('q')
			->orderBy('LENGTH(q.name)', 'asc')
			->addOrderBy('q.name', 'asc')
			->getQuery()
			->getResult();

		$data = [];
		/** @var VoiceCategory $cat */
		foreach ($cats as $cat) {
			$voices = $cat->getVoices()->getValues();
			$cat = [
				'id' => $cat->getId(),
				'title' => $cat->getName(),
				'data' => []
			];
			/** @var Voice $voice */
			foreach ($voices as $voice) {
				$tab = $accessor->getValue($cat['data'], '[' . $voice->getTab() . ']');
				if ($tab) {
					array_push($cat['data'][$voice->getTab()]['section'], [
						'id' => $voice->getId(),
						'title' => $voice->getName(),
						'url' => $voice->getUrl()
					]);
				} else {
					$cat['data'][$voice->getTab()] = [
						'title' => $voice->getTab(),
						'section' => [
							[
								'id' => $voice->getId(),
								'title' => $voice->getName(),
								'url' => $voice->getUrl()
							]
						]
					];
				}
			}
			$voiceData = [];
			foreach ($cat['data'] as $v) {
				array_push($voiceData, $v);
			}
			$cat['data'] = $voiceData;

			array_push($data, $cat);
		}

		return $data;
	}


	/**
	 * @param $id
	 * @return array
	 */
	public function detail($id)
	{
		$accessor = PropertyAccess::createPropertyAccessor();
		$em = $this->container->get('doctrine.orm.default_entity_manager');
		$voice = $em->getRepository('Admin:Voice')->findOneBy(['id' => $id]);
		$voices = $em->getRepository('Admin:Voice')->findByCat();

		$pre = null;
		$next = null;
		/**
		 * @var  $key
		 * @var Voice $value
		 */
		foreach ($voices as $key => $value) {
			if ($value->getId() == $id) {
				/** @var Voice $preData */
				$preData = $accessor->getValue($voices, '[' . ($key - 1) . ']');
				if ($preData) {
					$pre = $preData->getId();
				}
				/** @var Voice $nextData */
				$nextData = $accessor->getValue($voices, '[' . ($key + 1) . ']');
				if ($nextData) {
					$next = $nextData->getId();
				}
			}
		}
		return [
			'title' => $voice->getTab() . ' - ' . $voice->getName(),
			'voice' => $voice->getUrl(),
			'translation' => $voice->getTranslation(),
			'isCn' => $accessor->getValue($voice->getTranslation(), '[0][cntext]'),
			'pre' => $pre,
			'next' => $next
		];
	}
}