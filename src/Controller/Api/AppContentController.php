<?php
/**
 * Created by PhpStorm.
 * User: marquis
 * Date: 2019/2/11
 * Time: 5:56 PM
 */

namespace Admin\Controller\Api;


use Admin\Entity\Content;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\PropertyAccess\PropertyAccess;
use Symfony\Component\Validator\Constraints\Collection;
use Symfony\Component\Validator\Constraints\NotBlank;
use Util\Json;

/**
 * Class AppContentController
 * @package Admin\Controller\Api
 */
class AppContentController extends AbstractApiController
{
	/**
	 * 获取内容列表
	 *
	 * @Route("/list", name="api.content.list")
	 * @param $request
	 * @Method({"GET"})
	 *
	 * @return \Symfony\Component\HttpFoundation\JsonResponse
	 */
	public function contentList(Request $request)
	{
		$em = $this->get('doctrine.orm.default_entity_manager');
		$queryBuilder = $em
			->getRepository('Admin:Content')
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
		/** @var Content $item */
		foreach ($paginationResult['items'] as $item) {
			array_push($items, [
				'id' => $item->getId(),
				'title' => $item->getTitle(),
				'photo' => $item->getPhoto(),
				'summary' => $item->getSummary(),
				'extra' => $item->getExtra() ? $item->getExtra() : '-',
				'catId' => $item->getContentCat() ? $item->getContentCat()->getId() : '',
				'cat' => $item->getContentCat() ? $item->getContentCat()->getTitle() : '-',
				'campus' => $item->getCampus() ? $item->getCampus()->getTitle() : '-',
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
	 * @Route("/detail", name="api.content.detail")
	 * @Method({"GET"})
	 *
	 * @param Request $request
	 * @return \Symfony\Component\HttpFoundation\JsonResponse
	 */
	public function detailContent(Request $request)
	{
		$id = $request->query->get('id');
		// 检查ID是否为空
		if ($id === null) {
			return self::createFailureJSONResponse('fail');
		}

		$em = $this->get('doctrine.orm.default_entity_manager');
		$contentRepo = $em->getRepository('Admin:Content');
		/** @var Content $content */
		$content = $contentRepo->findOneBy(['id' => $id]);
		// 检查Content是否为空
		if ($content === null) {
			return self::createFailureJSONResponse('fail');
		}

		$detail = [
			'id' => $content->getId(),
			'title' => $content->getTitle(),
			'photo' => $content->getPhoto(),
			'summary' => $content->getSummary(),
			'content' => $content->getContent(),
			'extra' => $content->getExtra(),
			'catId' => $content->getContentCat() ? $content->getContentCat()->getId() : '',
			'campusId' => $content->getCampus() ? $content->getCampus()->getId() : ''
		];

		return self::createSuccessJSONResponse($detail);
	}

	/**
	 * @Route("/create", name="api.content.create")
	 * @Method({"POST"})
	 *
	 * @param Request $request
	 * @return \Symfony\Component\HttpFoundation\JsonResponse
	 */
	public function createContent(Request $request)
	{
		$data = $request->request->all();

		$validator = $this->get('validator');
		$collectionConstraint = new Collection([
			'title' => [
				new NotBlank()
			],
			'photo' => [],
			'summary' => [],
			'content' => [
				new NotBlank()
			],
			'extra' => [],
			'catId' => [],
			'campusId' => []
		]);

		$errors = $validator->validate($data, $collectionConstraint);
		if (count($errors) > 0) {
			return self::createFailureJSONResponse('fail', 100, $this->getErrors($errors));
		} else {
			$contentService = $this->get('admin.service.content');
			try {
				$content = new Content();
				/** @var Content $content */
				$content = $contentService->save($content, $data);

				$data['id'] = $content->getId();
				$data['cat'] = $content->getContentCat() ? $content->getContentCat()->getTitle() : '';
				$data['del'] = false;
			} catch (\Exception $e) {
				return self::createFailureJSONResponse('fail');
			}
		}

		return self::createSuccessJSONResponse($data, 'success');
	}

	/**
	 * @Route("/update", name="api.content.update")
	 * @Method({"POST"})
	 *
	 * @param Request $request
	 * @return \Symfony\Component\HttpFoundation\JsonResponse
	 */
	public function updateContent(Request $request)
	{
		$data = $request->request->all();
		$accessor = PropertyAccess::createPropertyAccessor();
		$em = $this->get('doctrine.orm.default_entity_manager');
		$contentRepo = $em->getRepository('Admin:Content');
		$id = $accessor->getValue($data, '[id]');
		unset($data['id']);
		unset($data['cat']);

		$validator = $this->get('validator');
		$collectionConstraint = new Collection([
			'title' => [
				new NotBlank()
			],
			'photo' => [],
			'summary' => [],
			'content' => [
				new NotBlank()
			],
			'extra' => [],
			'catId' => [],
			'campusId' => []
		]);

		$errors = $validator->validate($data, $collectionConstraint);
		if (count($errors) > 0) {
			return self::createFailureJSONResponse('fail', 100, $this->getErrors($errors));
		} else {
			$contentService = $this->get('admin.service.content');
			try {
				$content = $contentRepo->findOneBy(['id' => $id]);
				if ($content === null) {
					return self::createFailureJSONResponse('fail');
				}
				/** @var Content $content */
				$contentService->save($content, $data);

				$data['id'] = $id;
				$data['cat'] = $content->getContentCat() ? $content->getContentCat()->getTitle() : '';
				$data['del'] = false;
			} catch (\Exception $e) {
				return self::createFailureJSONResponse('fail');
			}
		}

		return self::createSuccessJSONResponse($data, 'success');
	}

	/**
	 * 删除页面
	 *
	 * @Route("/delete", name="api.content.delete")
	 * @Method({"POST"})
	 * @param Request $request
	 * @return \Symfony\Component\HttpFoundation\JsonResponse
	 */
	public function deleteContent(Request $request)
	{
		$data = $request->request->all();
		$accessor = PropertyAccess::createPropertyAccessor();
		$id = $accessor->getValue($data, '[id]');

		$em = $this->get('doctrine.orm.default_entity_manager');
		$contentRepo = $em->getRepository('Admin:Content');
		$content = $contentRepo->findOneBy(['id' => $id]);
		if ($content === null) {
			return self::createFailureJSONResponse('fail');
		}

		try {
			$em->remove($content);
			$em->flush();
		} catch (\Exception $e) {
			$em->rollback();
		}

		return self::createSuccessJSONResponse([], 'success');
	}
}