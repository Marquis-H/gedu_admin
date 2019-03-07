<?php
/**
 * Created by PhpStorm.
 * User: marquis
 * Date: 2019/2/11
 * Time: 4:29 PM
 */

namespace Admin\Controller\Api;


use Admin\Entity\ContentCat;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\PropertyAccess\PropertyAccess;
use Symfony\Component\Validator\Constraints\Collection;
use Symfony\Component\Validator\Constraints\NotBlank;
use Util\Json;

class AppContentCatController extends AbstractApiController
{
	/**
	 * 获取内容分类列表
	 *
	 * @Route("/list", name="api.content_cat.list")
	 * @param $request
	 * @Method({"GET"})
	 *
	 * @return \Symfony\Component\HttpFoundation\JsonResponse
	 */
	public function contentCatList(Request $request)
	{
		$em = $this->get('doctrine.orm.default_entity_manager');
		$queryBuilder = $em
			->getRepository('Admin:ContentCat')
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
		/** @var ContentCat $item */
		foreach ($paginationResult['items'] as $item) {
			array_push($items, [
				'id' => $item->getId(),
				'title' => $item->getTitle(),
				'slug' => $item->getSlug(),
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
	 * @Route("/create", name="api.content_cat.create")
	 * @param $request
	 * @Method({"POST"})
	 *
	 * @return \Symfony\Component\HttpFoundation\JsonResponse
	 */
	public function createContentCat(Request $request)
	{
		$data = $request->request->all();
		$accessor = PropertyAccess::createPropertyAccessor();
		$em = $this->get('doctrine.orm.default_entity_manager');
		$contentCatRepo = $em->getRepository('Admin:ContentCat');

		$validator = $this->get('validator');
		$collectionConstraint = new Collection([
			'title' => [
				new NotBlank()
			],
			'slug' => []
		]);

		$errors = $validator->validate($data, $collectionConstraint);
		if ($contentCatRepo->findOneBy(['title' => $accessor->getValue($data, '[title]')])) {
			return self::createFailureJSONResponse('fail', 100, ['table.content_cat_unique']);
		} else if (count($errors) > 0) {
			return self::createFailureJSONResponse('fail', 100, $this->getErrors($errors));
		} else {
			$contentService = $this->get('admin.service.content');
			try {
				$contentCat = new ContentCat();
				/** @var ContentCat $contentCat */
				$contentCat = $contentService->saveCat($contentCat, $data);

				$data['id'] = $contentCat->getId();
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
	 * @Route("/update", name="api.content_cat.update")
	 * @param $request
	 * @Method({"POST"})
	 *
	 * @return \Symfony\Component\HttpFoundation\JsonResponse
	 */
	public function updateContentCat(Request $request)
	{
		$data = $request->request->all();
		$accessor = PropertyAccess::createPropertyAccessor();
		$em = $this->get('doctrine.orm.default_entity_manager');
		$contentCatRepo = $em->getRepository('Admin:ContentCat');
		$id = $accessor->getValue($data, '[id]');
		unset($data['id']);
		unset($data['del']);

		$validator = $this->get('validator');
		$collectionConstraint = new Collection(
			[
				'title' => [
					new NotBlank()
				],
				'slug' => []
			]
		);

		$errors = $validator->validate($data, $collectionConstraint);
		if ($contentCatRepo->isUnique($accessor->getValue($data, '[title]'), $id)) {
			return self::createFailureJSONResponse('fail', 100, ['table.content_cat_unique']);
		} else if (count($errors) > 0) {
			return self::createFailureJSONResponse('fail', 100, $this->getErrors($errors));
		} else {
			$contentService = $this->get('admin.service.content');
			try {
				$contentCat = $contentCatRepo->findOneBy(['id' => $id]);
				if ($contentCat === null) {
					return self::createFailureJSONResponse('fail');
				}
				/** @var ContentCat $contentCat */
				$contentService->saveCat($contentCat, $data);

			} catch (\Exception $e) {
				return self::createFailureJSONResponse('fail');
			}
		}

		return self::createSuccessJSONResponse($data, 'success');
	}

	/**
	 * 删除
	 *
	 * @Route("/delete", name="api.content_cat.delete")
	 * @param $request
	 * @Method({"POST"})
	 *
	 * @return \Symfony\Component\HttpFoundation\JsonResponse
	 */
	public function deleteContentCat(Request $request)
	{
		$data = $request->request->all();
		$accessor = PropertyAccess::createPropertyAccessor();
		$id = $accessor->getValue($data, '[id]');

		$em = $this->get('doctrine.orm.default_entity_manager');
		$contentCatRepo = $em->getRepository('Admin:ContentCat');
		$contentCat = $contentCatRepo->findOneBy(['id' => $id]);
		if ($contentCat === null) {
			return self::createFailureJSONResponse('fail');
		}

		try {
			$em->remove($contentCat);
			$em->flush();
		} catch (\Exception $e) {
			$em->rollback();
		}

		return self::createSuccessJSONResponse([], 'success');
	}

	/**
	 * 所有记录
	 *
	 * @Route("/items", name="api.content_cat.items")
	 * @param $request
	 * @Method({"GET"})
	 *
	 * @return \Symfony\Component\HttpFoundation\JsonResponse
	 */
	public function items(Request $request)
	{
		$em = $this->get('doctrine.orm.default_entity_manager');
		$campus = $em->getRepository('Admin:ContentCat')->findAll();

		$data = [];
		foreach ($campus as $value) {
			array_push($data, [
				'label' => $value->getTitle(),
				'value' => $value->getId()
			]);
		}

		return self::createSuccessJSONResponse($data, 'success');
	}
}