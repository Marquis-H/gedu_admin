<?php
/**
 * Created by PhpStorm.
 * User: marquis
 * Date: 2019/4/9
 * Time: 9:40 PM
 */

namespace Admin\Controller\Api;


use Admin\Entity\Voice;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\PropertyAccess\PropertyAccess;
use Symfony\Component\Validator\Constraints\Collection;
use Symfony\Component\Validator\Constraints\NotBlank;
use Util\Json;

class VoiceController extends AbstractApiController
{
	/**
	 * 获取音频列表
	 *
	 * @Route("/list", name="api.voice.list")
	 * @Method({"GET"})
	 *
	 * @param Request $request
	 * @return \Symfony\Component\HttpFoundation\JsonResponse
	 */
	public function wordList(Request $request)
	{
		$em = $this->get('doctrine.orm.default_entity_manager');
		$queryBuilder = $em
			->getRepository('Admin:Voice')
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
		/** @var Voice $item */
		foreach ($paginationResult['items'] as $item) {
			array_push($items, [
				'id' => $item->getId(),
				'name' => $item->getName(),
				'url' => $item->getUrl(),
				'tab' => $item->getTab(),
				'cat' => $item->getVoiceCategory() ? $item->getVoiceCategory()->getName() : '-',
				'catId' => $item->getVoiceCategory() ? $item->getVoiceCategory()->getId() : '',
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
	 * @Route("/create", name="api.voice.create")
	 * @Method({"POST"})
	 *
	 * @param Request $request
	 * @return \Symfony\Component\HttpFoundation\JsonResponse
	 */
	public function createVoice(Request $request)
	{
		$data = $request->request->all();
		$validator = $this->get('validator');
		$collectionConstraint = new Collection([
			'name' => [
				new NotBlank()
			],
			'catId' => [
				new NotBlank()
			],
			'url' => [],
			'tab' => []
		]);

		$errors = $validator->validate($data, $collectionConstraint);
		if (count($errors) > 0) {
			return self::createFailureJSONResponse('fail', 100, $this->getErrors($errors));
		} else {
			$VoiceService = $this->get('admin.service.voice');
			try {
				$voice = new Voice();
				/** @var Voice $voice */
				$voice = $VoiceService->save($voice, $data);

				$data['id'] = $voice->getId();
				$data['cat'] = $voice->getVoiceCategory() ? $voice->getVoiceCategory()->getName() : '-';
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
	 * @Route("/update", name="api.voice.update")
	 * @Method({"POST"})
	 *
	 * @param Request $request
	 * @return \Symfony\Component\HttpFoundation\JsonResponse
	 */
	public function updateVoice(Request $request)
	{
		$data = $request->request->all();
		$accessor = PropertyAccess::createPropertyAccessor();
		$em = $this->get('doctrine.orm.default_entity_manager');
		$voiceRepo = $em->getRepository('Admin:Voice');
		$id = $accessor->getValue($data, '[id]');
		unset($data['id']);
		unset($data['cat']);
		unset($data['del']);

		$validator = $this->get('validator');
		$collectionConstraint = new Collection(
			[
				'name' => [
					new NotBlank()
				],
				'catId' => [
					new NotBlank()
				],
				'url' => [],
				'tab' => []
			]
		);

		$errors = $validator->validate($data, $collectionConstraint);
		if (count($errors) > 0) {
			return self::createFailureJSONResponse('fail', 100, $this->getErrors($errors));
		} else {
			$voiceService = $this->get('admin.service.voice');
			try {
				$voice = $voiceRepo->findOneBy(['id' => $id]);
				if ($voice === null) {
					return self::createFailureJSONResponse('fail');
				}
				/** @var Voice $voice */
				$voice = $voiceService->save($voice, $data);

				$data['id'] = $voice->getId();
				$data['cat'] = $voice->getVoiceCategory() ? $voice->getVoiceCategory()->getName() : '-';
			} catch (\Exception $e) {
				return self::createFailureJSONResponse('fail');
			}
		}

		return self::createSuccessJSONResponse($data, 'success');
	}

	/**
	 * 删除
	 *
	 * @Route("/delete", name="api.voice.delete")
	 * @Method({"POST"})
	 *
	 * @param Request $request
	 * @return \Symfony\Component\HttpFoundation\JsonResponse
	 */
	public function deleteVoice(Request $request)
	{
		$data = $request->request->all();
		$accessor = PropertyAccess::createPropertyAccessor();
		$id = $accessor->getValue($data, '[id]');

		$em = $this->get('doctrine.orm.default_entity_manager');
		$voiceRepo = $em->getRepository('Admin:Voice');
		$voice = $voiceRepo->findOneBy(['id' => $id]);
		if ($voice === null) {
			return self::createFailureJSONResponse('fail');
		}

		try {
			$em->remove($voice);
			$em->flush();
		} catch (\Exception $e) {
			$em->rollback();
		}

		return self::createSuccessJSONResponse([], 'success');
	}
}