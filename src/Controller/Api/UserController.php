<?php
/**
 * Created by PhpStorm.
 * User: Marquis
 * Date: 2018/8/20
 * Time: 下午5:00
 */

namespace Admin\Controller\Api;

use Admin\Entity\BackendGroup;
use Admin\Entity\BackendUser;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\PropertyAccess\PropertyAccess;
use Symfony\Component\Validator\Constraints\Collection;
use Symfony\Component\Validator\Constraints\NotBlank;
use Util\Json;

/**
 * Class UserController
 * @package Admin\Controller\Api
 */
class UserController extends AbstractApiController
{
	/**
	 * 获取用户信息
	 *
	 * @Route("/info", name="api.user.info")
	 * @Method({"GET"})
	 * @param $request
	 *
	 * @return \Symfony\Component\HttpFoundation\JsonResponse
	 */
	public function info(Request $request)
	{
		/** @var BackendUser $user */
		$user = $this->getUser();

		return $this->createSuccessJSONResponse([
			'name' => $user->getUsername(),
			'roles' => $user->getRoles(),
			'introduction' => '我是管理员',
			'avatar' => 'https://wpimg.wallstcn.com/f778738c-e4f8-4870-b634-56703b4acafe.gif',
			'setting' => [
				'domain' => $this->getParameter('domain')
			]
		]);
	}

	/**
	 * 获取后台用户列表
	 *
	 * @Route("/list", name="api.user.list")
	 * @param $request
	 * @Method({"GET"})
	 *
	 * @return \Symfony\Component\HttpFoundation\JsonResponse
	 */
	public function userList(Request $request)
	{
		$em = $this->get('doctrine.orm.default_entity_manager');
		$queryBuilder = $em
			->getRepository('Admin:BackendUser')
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

		/** @var BackendUser $item */
		foreach ($paginationResult['items'] as $item) {
			$groups = [];
			/** @var BackendGroup $value */
			foreach ($item->getBackendGroups()->getValues() as $value) {
				array_push($groups, $value->getId());
			}

			array_push($items, [
				'id' => $item->getId(),
				'isActive' => $item->getEnabled(),
				'username' => $item->getUsername(),
				'isSuperAdmin' => $item->getIsSuperAdmin(),
				'name' => $item->fullName(),
				'email' => $item->getEmail(),
				'lastLogin' => '-',
				'firstname' => $item->getFirstname(),
				'lastname' => $item->getLastname(),
				'role' => $item->getRoles(),
				'group' => $groups,
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
	 * 创建后台用户
	 *
	 * @Route("/create", name="api.user.create")
	 * @param $request
	 * @Method({"POST"})
	 *
	 * @return \Symfony\Component\HttpFoundation\JsonResponse
	 */
	public function createUser(Request $request)
	{
		$data = $request->request->all();
		$accessor = PropertyAccess::createPropertyAccessor();
		$em = $this->get('doctrine.orm.default_entity_manager');
		$backendUserRepo = $em->getRepository('Admin:BackendUser');

		$validator = $this->get('validator');
		$collectionConstraint = new Collection([
			'username' => [
				new NotBlank()
			],
			'email' => [
				new NotBlank()
			],
			'password' => [
				new NotBlank()
			],
			'checkPass' => [],
			'isSuperAdmin' => [],
			'isActive' => [],
			'firstname' => [],
			'lastname' => [],
			'role' => [],
			'group' => []
		]);

		$errors = $validator->validate($data, $collectionConstraint);
		if ($backendUserRepo->findOneBy(['username' => $accessor->getValue($data, '[username]')])) {
			return self::createFailureJSONResponse('fail', 100, ['table.username_unique']);
		} else if (count($errors) > 0) {
			return self::createFailureJSONResponse('fail', 100, $this->getErrors($errors));
		} else {
			$userService = $this->get('admin.service.user');
			try {
				$backUser = new BackendUser();
				/** @var BackendUser $backUser */
				$backUser = $userService->save($backUser, $data);

				$data['id'] = $backUser->getId();
				$data['lastLogin'] = '-';
				$data['name'] = $backUser->fullName();
				$data['del'] = false;
			} catch (\Exception $e) {
				return self::createFailureJSONResponse('fail');
			}
		}

		return self::createSuccessJSONResponse($data, 'success');
	}

	/**
	 * 更新后台用户
	 *
	 * @Route("/update", name="api.user.update")
	 * @param $request
	 * @Method({"POST"})
	 *
	 * @return \Symfony\Component\HttpFoundation\JsonResponse
	 */
	public function updateUser(Request $request)
	{
		$data = $request->request->all();
		$accessor = PropertyAccess::createPropertyAccessor();
		$em = $this->get('doctrine.orm.default_entity_manager');
		$backendUserRepo = $em->getRepository('Admin:BackendUser');
		$id = $accessor->getValue($data, '[id]');
		unset($data['id']);
		unset($data['name']);
		unset($data['lastLogin']);
		unset($data['del']);

		$validator = $this->get('validator');
		$validatorData = [
			'username' => [
				new NotBlank()
			],
			'email' => [
				new NotBlank()
			],
			'password' => [],
			'checkPass' => [],
			'isSuperAdmin' => [],
			'isActive' => [],
			'firstname' => [],
			'lastname' => [],
			'role' => [],
			'group' => []
		];
		if (!$accessor->getValue($data, '[password]')) {
			unset($validatorData['password']);
			unset($validatorData['checkPass']);
		}

		$collectionConstraint = new Collection(
			$validatorData
		);

		$errors = $validator->validate($data, $collectionConstraint);
		$isUnique = $backendUserRepo->isUnique($accessor->getValue($data, '[username]'), $id);
		if ($isUnique > 0) {
			return self::createFailureJSONResponse('fail', 100, ['table.username_unique']);
		} else if (count($errors) > 0) {
			return self::createFailureJSONResponse('fail', 100, $this->getErrors($errors));
		} else {
			$userService = $this->get('admin.service.user');
			try {
				$backUser = $backendUserRepo->findOneBy(['id' => $id]);
				if ($backUser === null) {
					return self::createFailureJSONResponse('fail');
				}
				/** @var BackendUser $backUser */
				$backUser = $userService->save($backUser, $data);

				$data['lastLogin'] = '-';
				$data['name'] = $backUser->fullName();
			} catch (\Exception $e) {
				return self::createFailureJSONResponse('fail');
			}
		}

		return self::createSuccessJSONResponse($data, 'success');
	}

	/**
	 * 删除后台用户
	 *
	 * @Route("/delete", name="api.user.delete")
	 * @param $request
	 * @Method({"POST"})
	 *
	 * @return \Symfony\Component\HttpFoundation\JsonResponse
	 */
	public function deleteUser(Request $request)
	{
		$data = $request->request->all();
		$accessor = PropertyAccess::createPropertyAccessor();
		$id = $accessor->getValue($data, '[id]');

		$em = $this->get('doctrine.orm.default_entity_manager');
		$backendUserRepo = $em->getRepository('Admin:BackendUser');
		$backendUser = $backendUserRepo->findOneBy(['id' => $id]);
		if ($backendUser === null) {
			return self::createFailureJSONResponse('fail');
		}

		try {
			$em->remove($backendUser);
			$em->flush();
		} catch (\Exception $e) {
			$em->rollback();
		}

		return self::createSuccessJSONResponse([], 'success');
	}
}