<?php
/**
 * Created by PhpStorm.
 * User: marquis
 * Date: 2019/1/31
 * Time: 10:39 AM
 */

namespace Admin\Controller\Api;


use Admin\Entity\Campus;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\PropertyAccess\PropertyAccess;
use Symfony\Component\Validator\Constraints\Collection;
use Symfony\Component\Validator\Constraints\NotBlank;
use Util\Json;

class CampusController extends AbstractApiController
{
	/**
	 * 获取校区列表
	 *
	 * @Route("/list", name="api.campus.list")
	 * @param $request
	 * @Method({"GET"})
	 *
	 * @return \Symfony\Component\HttpFoundation\JsonResponse
	 */
	public function campusList(Request $request)
	{
		$em = $this->get('doctrine.orm.default_entity_manager');
		$queryBuilder = $em
			->getRepository('Admin:Campus')
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
		/** @var Campus $item */
		foreach ($paginationResult['items'] as $item) {
			array_push($items, [
				'id' => $item->getId(),
				'title' => $item->getTitle(),
				'infomation' => $item->getInfomation() ? $item->getInfomation() : '-'
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
	 * @Route("/create", name="api.campus.create")
	 * @param $request
	 * @Method({"POST"})
	 *
	 * @return \Symfony\Component\HttpFoundation\JsonResponse
	 */
	public function createCampus(Request $request)
	{
		$data = $request->request->all();
		$accessor = PropertyAccess::createPropertyAccessor();
		$em = $this->get('doctrine.orm.default_entity_manager');
		$campusRepo = $em->getRepository('Admin:Campus');

		$validator = $this->get('validator');
		$collectionConstraint = new Collection([
			'title' => [
				new NotBlank()
			],
			'infomation' => []
		]);

		$errors = $validator->validate($data, $collectionConstraint);
		if ($campusRepo->findOneBy(['title' => $accessor->getValue($data, '[title]')])) {
			return self::createFailureJSONResponse('fail', 100, ['table.campus_unique']);
		} else if (count($errors) > 0) {
			return self::createFailureJSONResponse('fail', 100, $this->getErrors($errors));
		} else {
			$campusService = $this->get('admin.service.campus');
			try {
				$campus = new Campus();
				/** @var Campus $campus */
				$campus = $campusService->save($campus, $data);

				$data['id'] = $campus->getId();
				$data['infomation'] = $campus->getInfomation() ? $campus->getInfomation() : '-';
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
	 * @Route("/update", name="api.campus.update")
	 * @param $request
	 * @Method({"POST"})
	 *
	 * @return \Symfony\Component\HttpFoundation\JsonResponse
	 */
	public function updateCampus(Request $request)
	{
		$data = $request->request->all();
		$accessor = PropertyAccess::createPropertyAccessor();
		$em = $this->get('doctrine.orm.default_entity_manager');
		$campusRepo = $em->getRepository('Admin:Campus');
		$id = $accessor->getValue($data, '[id]');
		unset($data['id']);
		unset($data['del']);

		$validator = $this->get('validator');
		$collectionConstraint = new Collection(
			[
				'title' => [
					new NotBlank()
				],
				'infomation' => []
			]
		);

		$errors = $validator->validate($data, $collectionConstraint);
		$isUnique = $campusRepo->isUnique($accessor->getValue($data, '[title]'), $id);
		if ($isUnique > 0) {
			return self::createFailureJSONResponse('fail', 100, ['table.campus_unique']);
		} else if (count($errors) > 0) {
			return self::createFailureJSONResponse('fail', 100, $this->getErrors($errors));
		} else {
			$campusService = $this->get('admin.service.campus');
			try {
				$campus = $campusRepo->findOneBy(['id' => $id]);
				if ($campus === null) {
					return self::createFailureJSONResponse('fail');
				}
				/** @var Campus $campus */
				$campusService->save($campus, $data);

				$data['id'] = $campus->getId();
				$data['del'] = false;
			} catch (\Exception $e) {
				return self::createFailureJSONResponse('fail');
			}
		}

		return self::createSuccessJSONResponse($data, 'success');
	}

	/**
	 * 删除
	 *
	 * @Route("/delete", name="api.campus.delete")
	 * @param $request
	 * @Method({"POST"})
	 *
	 * @return \Symfony\Component\HttpFoundation\JsonResponse
	 */
	public function deleteCampus(Request $request)
	{
		$data = $request->request->all();
		$accessor = PropertyAccess::createPropertyAccessor();
		$id = $accessor->getValue($data, '[id]');

		$em = $this->get('doctrine.orm.default_entity_manager');
		$campusRepo = $em->getRepository('Admin:Campus');
		$campus = $campusRepo->findOneBy(['id' => $id]);
		if ($campus === null) {
			return self::createFailureJSONResponse('fail');
		}

		try {
			$em->remove($campus);
			$em->flush();
		} catch (\Exception $e) {
			$em->rollback();
		}

		return self::createSuccessJSONResponse([], 'success');
	}

	/**
	 * 所有记录
	 *
	 * @Route("/items", name="api.campus.items")
	 * @param $request
	 * @Method({"GET"})
	 *
	 * @return \Symfony\Component\HttpFoundation\JsonResponse
	 */
	public function items(Request $request)
	{
		$em = $this->get('doctrine.orm.default_entity_manager');
		$campus = $em->getRepository('Admin:Campus')->findAll();

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