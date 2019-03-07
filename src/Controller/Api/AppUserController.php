<?php
/**
 * Created by PhpStorm.
 * User: marquis
 * Date: 2019/1/31
 * Time: 5:42 PM
 */

namespace Admin\Controller\Api;


use Admin\Constants\Reward;
use Admin\Entity\RewardLog;
use Admin\Entity\User;
use phpDocumentor\Reflection\Types\Self_;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\PropertyAccess\PropertyAccess;
use Symfony\Component\Validator\Constraints\Collection;
use Symfony\Component\Validator\Constraints\NotBlank;
use Util\Json;

/**
 * Class AppUserController
 * @package Admin\Controller\Api
 */
class AppUserController extends AbstractApiController
{
	/**
	 * APP用户列表
	 *
	 * @Route("/list", name="api.app_user.list")
	 * @Method({"GET"})
	 *
	 * @param Request $request
	 * @return \Symfony\Component\HttpFoundation\JsonResponse
	 */
	public function userList(Request $request)
	{
		$em = $this->get('doctrine.orm.default_entity_manager');
		$queryBuilder = $em
			->getRepository('Admin:User')
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
		/** @var User $item */
		foreach ($paginationResult['items'] as $item) {
			$isBindWechat = $item->getWechatBinding();
			array_push($items, [
				'id' => $item->getId(),
				'name' => $item->getName(),
				'gender' => $item->getGender(),
				'birthday' => $item->getBirthday() ? $item->getBirthday()->format('Y-m-d') : '-',
				'phone' => $item->getPhone(),
				'isMember' => $item->getIsMember(),
				'campus' => $item->getCampus() ? $item->getCampus()->getTitle() : '-',
				'campusId' => $item->getCampus() ? $item->getCampus()->getId() : '',
				'createdAt' => $item->getCreatedAt()->format('Y-m-d'),
				'isEnable' => $item->getEnable(),
				'integral' => $item->getIntegral(),
				// 微信信息
				'nickname' => $item->getNickname() ? $item->getNickname() : '-',
				'avatar' => $item->getAvatar() ? $item->getAvatar() : null,
				'isBindWechat' => $isBindWechat,
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
	 * 创建APP用户
	 *
	 * @Route("/create", name="api.app_user.create")
	 * @Method({"POST"})
	 *
	 * @param Request $request
	 * @return \Symfony\Component\HttpFoundation\JsonResponse
	 */
	public function createUser(Request $request)
	{
		$data = $request->request->all();
		$accessor = PropertyAccess::createPropertyAccessor();
		$em = $this->get('doctrine.orm.default_entity_manager');
		$userRepo = $em->getRepository('Admin:User');

		$validator = $this->get('validator');
		$collectionConstraint = new Collection([
			'name' => [
				new NotBlank()
			],
			'gender' => [
				new NotBlank()
			],
			'birthday' => [],
			'campusId' => [
				new NotBlank()
			],
			'phone' => [
				new NotBlank()
			],
			'isEnable' => [],
			'isMember' => []
		]);

		$errors = $validator->validate($data, $collectionConstraint);
		$name = $accessor->getValue($data, '[name]');
		$phone = $accessor->getValue($data, '[phone]');
		if ($userRepo->findOneBy(['phone' => $phone, 'name' => $name])) {
			return self::createFailureJSONResponse('fail', 100, ['table.app_user_unique']);
		} else if (count($errors) > 0) {
			return self::createFailureJSONResponse('fail', 100, $this->getErrors($errors));
		} else {
			$userService = $this->get('app.service.app_user');
			try {
				$user = new User();
				/** @var User $user */
				$user = $userService->saveBackend($user, $data, true);

				$data['id'] = $user->getId();
				$data['isMember'] = (bool)$user->getIsMember();
				$data['campus'] = $user->getCampus() ? $user->getCampus()->getTitle() : '-';
				$data['createdAt'] = $user->getCreatedAt()->format('Y-m-d');
				$data['nickname'] = '-';
				$data['avatar'] = null;
				$data['isBindWechat'] = (bool)$user->getIsMember();
				$data['integral'] = $user->getIntegral();
				$data['del'] = false;
			} catch (\Exception $e) {
				return self::createFailureJSONResponse('fail');
			}
		}

		return self::createSuccessJSONResponse($data, 'success');
	}

	/**
	 * @Route("/update", name="api.app_user.update")
	 * @Method({"POST"})
	 *
	 * @param Request $request
	 * @return \Symfony\Component\HttpFoundation\JsonResponse
	 */
	public function updateUser(Request $request)
	{
		$data = $request->request->all();
		$accessor = PropertyAccess::createPropertyAccessor();
		$em = $this->get('doctrine.orm.default_entity_manager');
		$userRepo = $em->getRepository('Admin:User');
		$id = $accessor->getValue($data, '[id]');
		unset($data['id']);
		unset($data['campus']);
		unset($data['createdAt']);
		unset($data['nickname']);
		unset($data['avatar']);
		unset($data['isBindWechat']);
		unset($data['integral']);
		unset($data['del']);

		$validator = $this->get('validator');
		$validatorData = [
			'name' => [
				new NotBlank()
			],
			'gender' => [
				new NotBlank()
			],
			'birthday' => [],
			'campusId' => [
				new NotBlank()
			],
			'phone' => [
				new NotBlank()
			],
			'isEnable' => [],
			'isMember' => []
		];
		$collectionConstraint = new Collection(
			$validatorData
		);

		$errors = $validator->validate($data, $collectionConstraint);
		$isUnique = $userRepo->isUnique($accessor->getValue($data, '[phone]'), $id);
		if ($isUnique > 0) {
			return self::createFailureJSONResponse('fail', 100, ['table.app_user_unique']);
		} else if (count($errors) > 0) {
			return self::createFailureJSONResponse('fail', 100, $this->getErrors($errors));
		} else {
			$appUserService = $this->get('app.service.app_user');
			try {
				$user = $userRepo->findOneBy(['id' => $id]);
				if ($user === null) {
					return self::createFailureJSONResponse('fail');
				}
				/** @var User $user */
				$user = $appUserService->saveBackend($user, $data);

				$data['id'] = $user->getId();
				$data['campus'] = $user->getCampus() ? $user->getCampus()->getTitle() : '-';
				$data['createdAt'] = $user->getCreatedAt()->format('Y-m-d');
				$data['nickname'] = '-';
				$data['avatar'] = null;
				$data['isBindWechat'] = (bool)$user->getIsMember();
				$data['integral'] = $user->getIntegral();
				$data['del'] = false;

			} catch (\Exception $e) {
				return self::createFailureJSONResponse('fail');
			}
		}

		return self::createSuccessJSONResponse($data, 'success');
	}

	/**
	 * @Route("/delete", name="api.app_user.delete")
	 * @Method({"POST"})
	 *
	 * @param Request $request
	 * @return \Symfony\Component\HttpFoundation\JsonResponse
	 */
	public function deleteUser(Request $request)
	{
		$data = $request->request->all();
		$accessor = PropertyAccess::createPropertyAccessor();
		$id = $accessor->getValue($data, '[id]');

		$em = $this->get('doctrine.orm.default_entity_manager');
		$userRepo = $em->getRepository('Admin:User');
		$user = $userRepo->findOneBy(['id' => $id]);
		if ($user === null) {
			return self::createFailureJSONResponse('fail');
		}

		try {
			$em->remove($user);
			$em->flush();
		} catch (\Exception $e) {
			$em->rollback();
		}

		return self::createSuccessJSONResponse([], 'success');
	}

	/**
	 * 更新积分
	 *
	 * @Route("/update_integral", name="api.app_user.update_integral")
	 * @Method({"POST"})
	 *
	 * @param Request $request
	 * @return \Symfony\Component\HttpFoundation\JsonResponse
	 */
	public function changeIntegral(Request $request)
	{
		$data = $request->request->all();
		$accessor = PropertyAccess::createPropertyAccessor();
		$id = $accessor->getValue($data, '[id]');
		$integral = $accessor->getValue($data, '[integral]');

		$em = $this->get('doctrine.orm.default_entity_manager');
		$user = $em->getRepository('Admin:User')->findOneBy(['id' => $id]);
		if ($user === null) {
			return self::createFailureJSONResponse('error');
		}

		$oldIntegral = $user->getIntegral();
		if ($oldIntegral - $integral < 0) {
			return self::createFailureJSONResponse('积分不足', 100);
		}

		$user->setIntegral($oldIntegral - $integral);

		// 积分统计
		$rewardLog = new RewardLog();
		$rewardLog->setIntegral($integral);
		$rewardLog->setInfo(Reward::EXCHANGE);
		$rewardLog->setUser($user);

		try {
			$em->persist($user);
			$em->persist($rewardLog);
			$em->flush();

			return self::createSuccessJSONResponse(['integral' => $user->getIntegral()], 'success');
		} catch (\Exception $e) {
			return self::createFailureJSONResponse('error');
		}
	}
}