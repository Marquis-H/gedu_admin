<?php
/**
 * Created by PhpStorm.
 * User: marquis
 * Date: 2018/10/16
 * Time: 6:56 PM
 */

namespace Admin\Controller\Api;

use Admin\Entity\BackendRole;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\PropertyAccess\PropertyAccess;
use Symfony\Component\Validator\Constraints\Collection;
use Symfony\Component\Validator\Constraints\NotBlank;
use Util\Json;

/**
 * Class RoleController
 * @package Admin\Controller\Api
 */
class RoleController extends AbstractApiController
{
	/**
	 * 获取权限列表
	 *
	 * @Route("/list", name="api.role.list")
	 * @param $request
	 * @Method({"GET"})
	 *
	 * @return \Symfony\Component\HttpFoundation\JsonResponse
	 */
	public function roleList(Request $request)
	{
		$em = $this->get('doctrine.orm.default_entity_manager');
		$queryBuilder = $em
			->getRepository('Admin:BackendRole')
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
		/** @var BackendRole $item */
		foreach ($paginationResult['items'] as $item) {
			array_push($items, [
				'id' => $item->getId(),
				'name' => $item->getRole(),
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
	 * @Route("/create", name="api.role.create")
	 * @param $request
	 * @Method({"POST"})
	 *
	 * @return \Symfony\Component\HttpFoundation\JsonResponse
	 */
	public function createRole(Request $request)
	{
		$data = $request->request->all();
		$accessor = PropertyAccess::createPropertyAccessor();
		$em = $this->get('doctrine.orm.default_entity_manager');
		$backendRoleRepo = $em->getRepository('Admin:BackendRole');

		$validator = $this->get('validator');
		$collectionConstraint = new Collection([
			'name' => [
				new NotBlank()
			],
			'description' => []
		]);

		$errors = $validator->validate($data, $collectionConstraint);
		if ($backendRoleRepo->findOneBy(['role' => $accessor->getValue($data, '[name]')])) {
			return self::createFailureJSONResponse('fail', 100, ['table.name_unique']);
		} else if (count($errors) > 0) {
			return self::createFailureJSONResponse('fail', 100, $this->getErrors($errors));
		} else {
			$roleService = $this->get('admin.service.role');
			try {
				$role = new BackendRole();
				/** @var BackendRole $role */
				$role = $roleService->save($role, $data);

				$data['id'] = $role->getId();
				$data['description'] = $role->getDescription() ? $role->getDescription() : '-';
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
	 * @Route("/update", name="api.role.update")
	 * @param $request
	 * @Method({"POST"})
	 *
	 * @return \Symfony\Component\HttpFoundation\JsonResponse
	 */
	public function updateRole(Request $request)
	{
		$data = $request->request->all();
		$accessor = PropertyAccess::createPropertyAccessor();
		$em = $this->get('doctrine.orm.default_entity_manager');
		$backendRoleRepo = $em->getRepository('Admin:BackendRole');
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
		$isUnique = $backendRoleRepo->isUnique($accessor->getValue($data, '[name]'), $id);
		if ($isUnique > 0) {
			return self::createFailureJSONResponse('fail', 100, ['table.name_unique']);
		} else if (count($errors) > 0) {
			return self::createFailureJSONResponse('fail', 100, $this->getErrors($errors));
		} else {
			$roleService = $this->get('admin.service.role');
			try {
				$backendRole = $backendRoleRepo->findOneBy(['id' => $id]);
				if ($backendRole === null) {
					return self::createFailureJSONResponse('fail');
				}
				/** @var BackendRole $backendRole */
				$roleService->save($backendRole, $data);

			} catch (\Exception $e) {
				return self::createFailureJSONResponse('fail');
			}
		}

		return self::createSuccessJSONResponse($data, 'success');
	}

	/**
	 * 删除
	 *
	 * @Route("/delete", name="api.role.delete")
	 * @param $request
	 * @Method({"POST"})
	 *
	 * @return \Symfony\Component\HttpFoundation\JsonResponse
	 */
	public function deleteRole(Request $request)
	{
		$data = $request->request->all();
		$accessor = PropertyAccess::createPropertyAccessor();
		$id = $accessor->getValue($data, '[id]');

		$em = $this->get('doctrine.orm.default_entity_manager');
		$backendRoleRepo = $em->getRepository('Admin:BackendRole');
		$backendRole = $backendRoleRepo->findOneBy(['id' => $id]);
		if ($backendRole === null) {
			return self::createFailureJSONResponse('fail');
		}

		try {
			$em->remove($backendRole);
			$em->flush();
		} catch (\Exception $e) {
			$em->rollback();
		}

		return self::createSuccessJSONResponse([], 'success');
	}

	/**
	 * 所有记录
	 *
	 * @Route("/items", name="api.role.items")
	 * @param $request
	 * @Method({"GET"})
	 *
	 * @return \Symfony\Component\HttpFoundation\JsonResponse
	 */
	public function items(Request $request)
	{
		$em = $this->get('doctrine.orm.default_entity_manager');
		$roles = $em->getRepository('Admin:BackendRole')->findAll();

		$data = [];
		foreach ($roles as $role) {
			array_push($data, [
				'label' => $role->getDescription() ? $role->getDescription() : $role->getRole(),
				'value' => $role->getRole()
			]);
		}

		return self::createSuccessJSONResponse($data, 'success');
	}
}