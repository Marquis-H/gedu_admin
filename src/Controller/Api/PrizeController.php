<?php
/**
 * Created by PhpStorm.
 * User: marquis
 * Date: 2019/2/12
 * Time: 4:47 PM
 */

namespace Admin\Controller\Api;


use Admin\Entity\Prize;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\PropertyAccess\PropertyAccess;
use Symfony\Component\Validator\Constraints\Collection;
use Symfony\Component\Validator\Constraints\NotBlank;
use Util\Json;

/**
 * Class PrizeController
 * @package Admin\Controller\Api
 */
class PrizeController extends AbstractApiController
{
	/**
	 * 获取奖品列表
	 *
	 * @Route("/list", name="api.prize.list")
	 * @Method({"GET"})
	 *
	 * @param Request $request
	 * @return \Symfony\Component\HttpFoundation\JsonResponse
	 */
	public function prizeList(Request $request)
	{
		$em = $this->get('doctrine.orm.default_entity_manager');
		$queryBuilder = $em
			->getRepository('Admin:Prize')
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
		/** @var Prize $item */
		foreach ($paginationResult['items'] as $item) {
			array_push($items, [
				'id' => $item->getId(),
				'title' => $item->getTitle(),
				'photo' => $item->getPhoto() ? $item->getPhoto() : '',
				'integral' => $item->getIntegral(),
				'campus' => $item->getCampus() ? $item->getCampus()->getTitle() : '',
				'campusId' => $item->getCampus() ? $item->getCampus()->getId() : '',
				'updatedAt' => $item->getUpdatedAt()->format('Y-m-d H:i'),
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
	 * @Route("/create", name="api.prize.create")
	 * @Method({"POST"})
	 *
	 * @param Request $request
	 * @return \Symfony\Component\HttpFoundation\JsonResponse
	 */
	public function createPrize(Request $request)
	{
		$data = $request->request->all();

		$validator = $this->get('validator');
		$collectionConstraint = new Collection([
			'title' => [
				new NotBlank()
			],
			'photo' => [],
			'campusId' => [],
			'integral' => [
				new NotBlank()
			]
		]);

		$errors = $validator->validate($data, $collectionConstraint);
		if (count($errors) > 0) {
			return self::createFailureJSONResponse('fail', 100, $this->getErrors($errors));
		} else {
			$prizeService = $this->get('admin.service.prize');
			try {
				$prize = new Prize();
				/** @var Prize $prize */
				$prize = $prizeService->save($prize, $data);

				$data['id'] = $prize->getId();
				$data['updatedAt'] = $prize->getUpdatedAt()->format('Y-m-d H:i');
				$data['campus'] = $prize->getCampus() ? $prize->getCampus()->getTitle() : '';
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
	 * @Route("/update", name="api.prize.update")
	 * @Method({"POST"})
	 *
	 * @param Request $request
	 * @return \Symfony\Component\HttpFoundation\JsonResponse
	 */
	public function updatePrize(Request $request)
	{
		$data = $request->request->all();
		$accessor = PropertyAccess::createPropertyAccessor();
		$em = $this->get('doctrine.orm.default_entity_manager');
		$prizeRepo = $em->getRepository('Admin:Prize');
		$id = $accessor->getValue($data, '[id]');
		unset($data['id']);
		unset($data['campus']);
		unset($data['del']);
		unset($data['updatedAt']);

		$validator = $this->get('validator');
		$collectionConstraint = new Collection(
			[
				'title' => [
					new NotBlank()
				],
				'photo' => [],
				'campusId' => [],
				'integral' => [
					new NotBlank()
				]
			]
		);

		$errors = $validator->validate($data, $collectionConstraint);
		if (count($errors) > 0) {
			return self::createFailureJSONResponse('fail', 100, $this->getErrors($errors));
		} else {
			$prizeService = $this->get('admin.service.prize');
			try {
				$prize = $prizeRepo->findOneBy(['id' => $id]);
				if ($prize === null) {
					return self::createFailureJSONResponse('fail');
				}
				/** @var Prize $prize */
				$prizeService->save($prize, $data);

				$data['id'] = $prize->getId();
				$data['updatedAt'] = $prize->getUpdatedAt()->format('Y-m-d H:i');
				$data['campus'] = $prize->getCampus() ? $prize->getCampus()->getTitle() : '';
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
	 * @Route("/delete", name="api.prize.delete")
	 * @Method({"POST"})
	 *
	 * @param Request $request
	 * @return \Symfony\Component\HttpFoundation\JsonResponse
	 */
	public function deletePrize(Request $request)
	{
		$data = $request->request->all();
		$accessor = PropertyAccess::createPropertyAccessor();
		$id = $accessor->getValue($data, '[id]');

		$em = $this->get('doctrine.orm.default_entity_manager');
		$prizeRepo = $em->getRepository('Admin:Prize');
		$prize = $prizeRepo->findOneBy(['id' => $id]);
		if ($prize === null) {
			return self::createFailureJSONResponse('fail');
		}

		try {
			$em->remove($prize);
			$em->flush();
		} catch (\Exception $e) {
			$em->rollback();
		}

		return self::createSuccessJSONResponse([], 'success');
	}
}