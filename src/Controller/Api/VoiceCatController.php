<?php
/**
 * Created by PhpStorm.
 * User: marquis
 * Date: 2019/4/9
 * Time: 9:45 PM
 */

namespace Admin\Controller\Api;


use Admin\Entity\VoiceCategory;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\PropertyAccess\PropertyAccess;
use Symfony\Component\Validator\Constraints\Collection;
use Symfony\Component\Validator\Constraints\NotBlank;
use Util\Json;

class VoiceCatController extends AbstractApiController
{
	/**
	 * 获取音频分类列表
	 *
	 * @Route("/list", name="api.voice_cat.list")
	 * @param $request
	 * @Method({"GET"})
	 *
	 * @return \Symfony\Component\HttpFoundation\JsonResponse
	 */
	public function voiceCatList(Request $request)
	{
		$em = $this->get('doctrine.orm.default_entity_manager');
		$queryBuilder = $em
			->getRepository('Admin:VoiceCategory')
			->createQueryBuilder('q');
		if ($request->query->has('sortOrder')) {
			$queryBuilder->orderBy('q.id', self::transSortOrder($request->query->get('sortOrder')));
		} else {
			$queryBuilder->orderBy('q.id', 'DESC');
		}

		//filters
		if ($request->query->get('filters')) {
			$filters = Json::decode($request->query->get('filters'));
			foreach ($filters as $key => $value) {
				if ($value) {
					switch ($key) {
						default:
							$queryBuilder->andWhere('q.' . $key . ' LIKE :' . $key)
								->setParameter($key, "%" . $value . "%");
							break;
					}
				}
			}
		}

		$paginationResult = self::pagination($request, $queryBuilder);
		$items = [];
		/** @var VoiceCategory $item */
		foreach ($paginationResult['items'] as $item) {
			array_push($items, [
				'id' => $item->getId(),
				'title' => $item->getName(),
				'del' => false
			]);
		}

		unset($paginationResult['items']); //移除不必要数据
		return self::createSuccessJSONResponse([
			'pagination' => $paginationResult,
			'items' => $items
		]);
	}

	/**
	 * 创建
	 *
	 * @Route("/create", name="api.voice_cat.create")
	 * @param $request
	 * @Method({"POST"})
	 *
	 * @return \Symfony\Component\HttpFoundation\JsonResponse
	 */
	public function createVoiceCat(Request $request)
	{
		$data = $request->request->all();
		$accessor = PropertyAccess::createPropertyAccessor();
		$em = $this->get('doctrine.orm.default_entity_manager');
		$voiceCatRepo = $em->getRepository('Admin:ContentCat');

		$validator = $this->get('validator');
		$collectionConstraint = new Collection([
			'title' => [
				new NotBlank()
			]
		]);

		$errors = $validator->validate($data, $collectionConstraint);
		if ($voiceCatRepo->findOneBy(['title' => $accessor->getValue($data, '[title]')])) {
			return self::createFailureJSONResponse('fail', 100, ['table.voice_cat_unique']);
		} else if (count($errors) > 0) {
			return self::createFailureJSONResponse('fail', 100, $this->getErrors($errors));
		} else {
			$voiceService = $this->get('admin.service.voice');
			try {
				$voiceCat = new VoiceCategory();
				/** @var VoiceCategory $voiceCat */
				$voiceCat = $voiceService->saveCat($voiceCat, $data);

				$data['id'] = $voiceCat->getId();
				$data['del'] = false;
			} catch (\Exception $e) {
				return self::createFailureJSONResponse('fail');
			}
		}

		return self::createSuccessJSONResponse($data, 'success');
	}

	/**
	 * 更新
	 *
	 * @Route("/update", name="api.voice_cat.update")
	 * @param $request
	 * @Method({"POST"})
	 *
	 * @return \Symfony\Component\HttpFoundation\JsonResponse
	 */
	public function updateVoiceCat(Request $request)
	{
		$data = $request->request->all();
		$accessor = PropertyAccess::createPropertyAccessor();
		$em = $this->get('doctrine.orm.default_entity_manager');
		$voiceCatRepo = $em->getRepository('Admin:VoiceCategory');
		$id = $accessor->getValue($data, '[id]');
		unset($data['id']);
		unset($data['del']);

		$validator = $this->get('validator');
		$collectionConstraint = new Collection(
			[
				'title' => [
					new NotBlank()
				]
			]
		);

		$errors = $validator->validate($data, $collectionConstraint);
		if ($voiceCatRepo->isUnique($accessor->getValue($data, '[title]'), $id)) {
			return self::createFailureJSONResponse('fail', 100, ['table.voice_cat_unique']);
		} else if (count($errors) > 0) {
			return self::createFailureJSONResponse('fail', 100, $this->getErrors($errors));
		} else {
			$voiceService = $this->get('admin.service.voice');
			try {
				$voiceCat = $voiceCatRepo->findOneBy(['id' => $id]);
				if ($voiceCat === null) {
					return self::createFailureJSONResponse('fail');
				}
				/** @var VoiceCategory $voiceCat */
				$voiceService->saveCat($voiceCat, $data);

			} catch (\Exception $e) {
				return self::createFailureJSONResponse('fail');
			}
		}

		return self::createSuccessJSONResponse($data, 'success');
	}

	/**
	 * 删除
	 *
	 * @Route("/delete", name="api.voice_cat.delete")
	 * @param $request
	 * @Method({"POST"})
	 *
	 * @return \Symfony\Component\HttpFoundation\JsonResponse
	 */
	public function deleteVoiceCat(Request $request)
	{
		$data = $request->request->all();
		$accessor = PropertyAccess::createPropertyAccessor();
		$id = $accessor->getValue($data, '[id]');

		$em = $this->get('doctrine.orm.default_entity_manager');
		$voiceCatRepo = $em->getRepository('Admin:VoiceCategory');
		$voiceCat = $voiceCatRepo->findOneBy(['id' => $id]);
		if ($voiceCat === null) {
			return self::createFailureJSONResponse('fail');
		}

		try {
			$em->remove($voiceCat);
			$em->flush();
		} catch (\Exception $e) {
			$em->rollback();
		}

		return self::createSuccessJSONResponse([], 'success');
	}

	/**
	 * 所有记录
	 *
	 * @Route("/items", name="api.voice_cat.items")
	 * @param $request
	 * @Method({"GET"})
	 *
	 * @return \Symfony\Component\HttpFoundation\JsonResponse
	 */
	public function items(Request $request)
	{
		$em = $this->get('doctrine.orm.default_entity_manager');
		$voiceCats = $em->getRepository('Admin:VoiceCategory')->findAll();

		$data = [];
		foreach ($voiceCats as $value) {
			array_push($data, [
				'label' => $value->getName(),
				'value' => $value->getId()
			]);
		}

		return self::createSuccessJSONResponse($data, 'success');
	}
}