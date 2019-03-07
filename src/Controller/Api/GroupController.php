<?php
/**
 * Created by PhpStorm.
 * User: marquis
 * Date: 2018/10/20
 * Time: 1:22 PM
 */

namespace Admin\Controller\Api;


use Admin\Entity\BackendGroup;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Component\PropertyAccess\PropertyAccess;
use Symfony\Component\Validator\Constraints\Collection;
use Symfony\Component\Validator\Constraints\NotBlank;
use Util\Json;

/**
 * Class GroupController
 * @package Admin\Controller\Api
 */
class GroupController extends AbstractApiController
{
	/**
	 * 获取用户组列表
	 *
	 * @Route("/list", name="api.group.list")
	 * @param $request
	 * @Method({"GET"})
	 *
	 * @return \Symfony\Component\HttpFoundation\JsonResponse
	 */
	public function groupList(Request $request)
	{
		$em = $this->get('doctrine.orm.default_entity_manager');
		$queryBuilder = $em
			->getRepository('Admin:BackendGroup')
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
		/** @var BackendGroup $item */
		foreach ($paginationResult['items'] as $item) {
			array_push($items, [
				'id' => $item->getId(),
				'name' => $item->getName(),
				'description' => $item->getDescription() ? $item->getDescription() : '-'
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
	 * @Route("/create", name="api.group.create")
	 * @param $request
	 * @Method({"POST"})
	 *
	 * @return \Symfony\Component\HttpFoundation\JsonResponse
	 */
	public function createGroup(Request $request)
	{
		$data = $request->request->all();
		$accessor = PropertyAccess::createPropertyAccessor();
		$em = $this->get('doctrine.orm.default_entity_manager');
		$backendGroupRepo = $em->getRepository('Admin:BackendGroup');

		$validator = $this->get('validator');
		$collectionConstraint = new Collection([
			'name' => [
				new NotBlank()
			],
			'description' => []
		]);

		$errors = $validator->validate($data, $collectionConstraint);
		if ($backendGroupRepo->findOneBy(['name' => $accessor->getValue($data, '[name]')])) {
			return self::createFailureJSONResponse('fail', 100, ['table.name_unique']);
		} else if (count($errors) > 0) {
			return self::createFailureJSONResponse('fail', 100, $this->getErrors($errors));
		} else {
			$groupService = $this->get('admin.service.group');
			try {
				$group = new BackendGroup();
				/** @var BackendGroup $group */
				$group = $groupService->save($group, $data);

				$data['id'] = $group->getId();
				$data['description'] = $group->getDescription() ? $group->getDescription() : '-';
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
	 * @Route("/update", name="api.group.update")
	 * @param $request
	 * @Method({"POST"})
	 *
	 * @return \Symfony\Component\HttpFoundation\JsonResponse
	 */
	public function updateGroup(Request $request)
	{
		$data = $request->request->all();
		$accessor = PropertyAccess::createPropertyAccessor();
		$em = $this->get('doctrine.orm.default_entity_manager');
		$backendGroupRepo = $em->getRepository('Admin:BackendGroup');
		$id = $accessor->getValue($data, '[id]');
		unset($data['id']);
		unset($data['del']);

		$validator = $this->get('validator');
		$collectionConstraint = new Collection(
			[
				'name' => [
					new NotBlank()
				],
				'description' => []
			]
		);

		$errors = $validator->validate($data, $collectionConstraint);
		$isUnique = $backendGroupRepo->isUnique($accessor->getValue($data, '[name]'), $id);
		if ($isUnique > 0) {
			return self::createFailureJSONResponse('fail', 100, ['table.name_unique']);
		} else if (count($errors) > 0) {
			return self::createFailureJSONResponse('fail', 100, $this->getErrors($errors));
		} else {
			$groupService = $this->get('admin.service.group');
			try {
				$backendGroup = $backendGroupRepo->findOneBy(['id' => $id]);
				if ($backendGroup === null) {
					return self::createFailureJSONResponse('fail');
				}
				/** @var BackendGroup $backendGroup */
				$groupService->save($backendGroup, $data);

			} catch (\Exception $e) {
				return self::createFailureJSONResponse('fail');
			}
		}

		return self::createSuccessJSONResponse($data, 'success');
	}

	/**
	 * 删除
	 *
	 * @Route("/delete", name="api.group.delete")
	 * @param $request
	 * @Method({"POST"})
	 *
	 * @return \Symfony\Component\HttpFoundation\JsonResponse
	 */
	public function deleteGroup(Request $request)
	{
		$data = $request->request->all();
		$accessor = PropertyAccess::createPropertyAccessor();
		$id = $accessor->getValue($data, '[id]');

		$em = $this->get('doctrine.orm.default_entity_manager');
		$backendGroupRepo = $em->getRepository('Admin:BackendGroup');
		$backendGroup = $backendGroupRepo->findOneBy(['id' => $id]);
		if ($backendGroup === null) {
			return self::createFailureJSONResponse('fail');
		}

		try {
			$em->remove($backendGroup);
			$em->flush();
		} catch (\Exception $e) {
			$em->rollback();
		}

		return self::createSuccessJSONResponse([], 'success');
	}

	/**
	 * 所有记录
	 *
	 * @Route("/items", name="api.group.items")
	 * @param $request
	 * @Method({"GET"})
	 *
	 * @return \Symfony\Component\HttpFoundation\JsonResponse
	 */
	public function items(Request $request)
	{
		$em = $this->get('doctrine.orm.default_entity_manager');
		$roles = $em->getRepository('Admin:BackendGroup')->findAll();

		$data = [];
		foreach ($roles as $role) {
			array_push($data, [
				'label' => $role->getName(),
				'value' => $role->getId()
			]);
		}

		return self::createSuccessJSONResponse($data, 'success');
	}
}