<?php
/**
 * Created by PhpStorm.
 * User: marquis
 * Date: 2019/2/8
 * Time: 2:06 PM
 */

namespace Admin\Controller\Api;

use Admin\Entity\Banner;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\PropertyAccess\PropertyAccess;
use Symfony\Component\Validator\Constraints\Collection;
use Symfony\Component\Validator\Constraints\NotBlank;
use Util\Json;

/**
 * Class BannerController
 * @package Admin\Controller\Api
 */
class BannerController extends AbstractApiController
{
	/**
	 * 获取Banner列表
	 *
	 * @Route("/list", name="api.banner.list")
	 * @Method({"GET"})
	 *
	 * @param Request $request
	 * @return \Symfony\Component\HttpFoundation\JsonResponse
	 */
	public function bannerList(Request $request)
	{
		$em = $this->get('doctrine.orm.default_entity_manager');
		$queryBuilder = $em
			->getRepository('Admin:Banner')
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
		/** @var Banner $item */
		foreach ($paginationResult['items'] as $item) {
			array_push($items, [
				'id' => $item->getId(),
				'photo' => $item->getPhoto(),
				'onlineAt' => $item->getOnlineAt() ? $item->getOnlineAt()->format('Y-m-d H:i') : '',
				'offlineAt' => $item->getOfflineAt() ? $item->getOfflineAt()->format('Y-m-d H:i') : '',
				'position' => $item->getPosition(),
				'slug' => $item->getSlug(),
				'campus' => $item->getCampus() ? $item->getCampus()->getTitle() : '-',
				'campusId' => $item->getCampus() ? $item->getCampus()->getId() : '',
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
	 * @Route("/create", name="api.banner.create")
	 * @Method({"POST"})
	 *
	 * @param Request $request
	 * @return \Symfony\Component\HttpFoundation\JsonResponse
	 */
	public function createBanner(Request $request)
	{
		$data = $request->request->all();
		$validator = $this->get('validator');
		$collectionConstraint = new Collection([
			'photo' => [
				new NotBlank()
			],
			'campusId' => [
				new NotBlank()
			],
			'onlineAt' => [],
			'offlineAt' => [],
			'position' => [],
			'slug' => []
		]);

		$errors = $validator->validate($data, $collectionConstraint);
		if (count($errors) > 0) {
			return self::createFailureJSONResponse('fail', 100, $this->getErrors($errors));
		} else {
			$bannerService = $this->get('admin.service.banner');
			try {
				$banner = new Banner();
				/** @var Banner $banner */
				$banner = $bannerService->save($banner, $data);

				$data['id'] = $banner->getId();
				$data['campus'] = $banner->getCampus() ? $banner->getCampus()->getTitle() : '-';
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
	 * @Route("/update", name="api.banner.update")
	 * @Method({"POST"})
	 *
	 * @param Request $request
	 * @return \Symfony\Component\HttpFoundation\JsonResponse
	 */
	public function updateBanner(Request $request)
	{
		$data = $request->request->all();
		$accessor = PropertyAccess::createPropertyAccessor();
		$em = $this->get('doctrine.orm.default_entity_manager');
		$bannerRepo = $em->getRepository('Admin:Banner');
		$id = $accessor->getValue($data, '[id]');
		unset($data['id']);
		unset($data['campus']);
		unset($data['del']);

		$validator = $this->get('validator');
		$collectionConstraint = new Collection(
			[
				'photo' => [
					new NotBlank()
				],
				'campusId' => [
					new NotBlank()
				],
				'onlineAt' => [],
				'offlineAt' => [],
				'position' => [],
				'slug' => []
			]
		);

		$errors = $validator->validate($data, $collectionConstraint);
		if (count($errors) > 0) {
			return self::createFailureJSONResponse('fail', 100, $this->getErrors($errors));
		} else {
			$bannerService = $this->get('admin.service.banner');
			try {
				$banner = $bannerRepo->findOneBy(['id' => $id]);
				if ($banner === null) {
					return self::createFailureJSONResponse('fail');
				}
				/** @var Banner $banner */
				$banner = $bannerService->save($banner, $data);

				$data['id'] = $banner->getId();
				$data['campus'] = $banner->getCampus() ? $banner->getCampus()->getTitle() : '-';
			} catch (\Exception $e) {
				return self::createFailureJSONResponse('fail');
			}
		}

		return self::createSuccessJSONResponse($data, 'success');
	}

	/**
	 * 删除
	 *
	 * @Route("/delete", name="api.banner.delete")
	 * @Method({"POST"})
	 *
	 * @param Request $request
	 * @return \Symfony\Component\HttpFoundation\JsonResponse
	 */
	public function deleteBanner(Request $request)
	{
		$data = $request->request->all();
		$accessor = PropertyAccess::createPropertyAccessor();
		$id = $accessor->getValue($data, '[id]');

		$em = $this->get('doctrine.orm.default_entity_manager');
		$bannerRepo = $em->getRepository('Admin:Banner');
		$banner = $bannerRepo->findOneBy(['id' => $id]);
		if ($banner === null) {
			return self::createFailureJSONResponse('fail');
		}

		try {
			$em->remove($banner);
			$em->flush();
		} catch (\Exception $e) {
			$em->rollback();
		}

		return self::createSuccessJSONResponse([], 'success');
	}
}