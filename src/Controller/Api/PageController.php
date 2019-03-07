<?php
/**
 * Created by PhpStorm.
 * User: marquis
 * Date: 2018/12/16
 * Time: 7:36 PM
 */

namespace Admin\Controller\Api;


use Admin\Entity\Page;
use Gedmo\Translatable\Entity\Repository\TranslationRepository;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\PropertyAccess\PropertyAccess;
use Symfony\Component\Validator\Constraints\Collection;
use Symfony\Component\Validator\Constraints\NotBlank;
use Util\Json;

/**
 * Class PageController
 * @package Admin\Controller\Api
 */
class PageController extends AbstractApiController
{
	/**
	 * 获取页面列表
	 *
	 * @Route("/list", name="api.page.list")
	 * @Method({"GET"})
	 * @param Request $request
	 * @return \Symfony\Component\HttpFoundation\JsonResponse
	 */
	public function pageList(Request $request)
	{
		$em = $this->get('doctrine.orm.default_entity_manager');
		$queryBuilder = $em
			->getRepository('Admin:Page')
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
								->setParameter($key, '%' . $value . '%');
							break;
					}
				}
			}
		}

		$paginationResult = self::pagination($request, $queryBuilder);
		$items = [];

		$locale = $request->getLocale();
		/** @var TranslationRepository $transRepo */
		$transRepo = $em->getRepository('GedmoTranslatable:Translation');
		/** @var Page $item */
		foreach ($paginationResult['items'] as $item) {
			$title = $transRepo->findTranslations($item);
			array_push($items, [
				'id' => $item->getId(),
				'path' => $item->getPath(),
				'title' => $title[$locale]['title'],
				'updatedAt' => $item->getUpdatedAt()->format('Y-m-d H:i'),
				'del' => false
			]);
		}

		unset($paginationResult['items']);
		return self::createSuccessJSONResponse([
			'pagination' => $paginationResult,
			'items' => $items
		]);
	}

	/**
	 * 获取详情
	 *
	 * @Route("/detail", name="api.page.detail")
	 * @Method({"GET"})
	 * @param Request $request
	 * @return \Symfony\Component\HttpFoundation\JsonResponse
	 */
	public function detailPage(Request $request)
	{
		$id = $request->query->get('id');
		// 检查ID是否为空
		if ($id === null) {
			return self::createFailureJSONResponse('fail');
		}

		$em = $this->get('doctrine.orm.default_entity_manager');
		$pageRepo = $em->getRepository('Admin:Page');
		/** @var Page $page */
		$page = $pageRepo->findOneBy(['id' => $id]);
		// 检查Page是否为空
		if ($page === null) {
			return self::createFailureJSONResponse('fail');
		}

		$locale = $request->getLocale();
		/** @var TranslationRepository $transRepo */
		$transRepo = $em->getRepository('GedmoTranslatable:Translation');
		$transRepo->findTranslations($page);
		$pageTranslation = $transRepo->findTranslations($page);
		$translation = $pageTranslation[$locale];
		$detail = [
			'id' => $page->getId(),
			'path' => $page->getPath(),
			'onlineAt' => $page->getOnlineAt() ? $page->getOnlineAt()->format('Y-m-d H:i:s') : '',
			'offlineAt' => $page->getOfflineAt() ? $page->getOfflineAt()->format('Y-m-d H:i:s') : '',
			'banner' => $page->getBanner() ? $page->getBanner() : '',
			'zh' => [
				'title' => $translation['title'],
				'navTitle' => $translation['navTitle'],
				'otherBanner' => $translation['otherBanner'],
				'summary' => $translation['summary'],
				'content' => $translation['content'],
				'metaTitle' => $translation['metaTitle'],
				'keywords' => $translation['keywords'],
				'description' => $translation['description']
			]
		];

		return self::createSuccessJSONResponse($detail);
	}

	/**
	 * 创建页面
	 *
	 * @Route("/create", name="api.page.create")
	 * @Method({"POST"})
	 * @param Request $request
	 * @return \Symfony\Component\HttpFoundation\JsonResponse
	 */
	public function createPage(Request $request)
	{
		$data = $request->request->all();
		$accessor = PropertyAccess::createPropertyAccessor();
		$em = $this->get('doctrine.orm.default_entity_manager');
		$pageRepo = $em->getRepository('Admin:Page');

		$validator = $this->get('validator');
		$collectionConstraint = new Collection([
			'path' => [
				new NotBlank()
			],
			'onlineAt' => [],
			'offlineAt' => [],
			'banner' => [],
			'title' => [
				new NotBlank()
			],
			'navTitle' => [],
			'otherBanner' => [],
			'summary' => [],
			'content' => [],
			'metaTitle' => [],
			'keywords' => [],
			'description' => []
		]);

		$errors = $validator->validate($data, $collectionConstraint);
		if ($pageRepo->findOneBy(['path' => $accessor->getValue($data, '[path]')])) {
			return self::createFailureJSONResponse('fail', 100, ['table.path_unique']);
		} else if (count($errors) > 0) {
			return self::createFailureJSONResponse('fail', 100, $this->getErrors($errors));
		} else {
			$pageService = $this->get('admin.service.page');
			try {
				$page = new Page();
				/** @var Page $page */
				$pageService->save($page, $data);
			} catch (\Exception $e) {
				var_dump($e->getMessage());
				return self::createFailureJSONResponse('fail');
			}
		}

		return self::createSuccessJSONResponse($data, 'success');
	}

	/**
	 * 更新页面
	 *
	 * @Route("/update", name="api.page.update")
	 * @Method({"POST"})
	 * @param Request $request
	 * @return \Symfony\Component\HttpFoundation\JsonResponse
	 */
	public function updatePage(Request $request)
	{
		$data = $request->request->all();
		$accessor = PropertyAccess::createPropertyAccessor();
		$em = $this->get('doctrine.orm.default_entity_manager');
		$pageRepo = $em->getRepository('Admin:Page');
		$id = $accessor->getValue($data, '[id]');
		unset($data['id']);

		$validator = $this->get('validator');
		$collectionConstraint = new Collection([
			'path' => [
				new NotBlank()
			],
			'onlineAt' => [],
			'offlineAt' => [],
			'banner' => [],
			'title' => [
				new NotBlank()
			],
			'navTitle' => [],
			'otherBanner' => [],
			'summary' => [],
			'content' => [],
			'metaTitle' => [],
			'keywords' => [],
			'description' => []
		]);

		$errors = $validator->validate($data, $collectionConstraint);
		$isUnique = $pageRepo->isUnique($accessor->getValue($data, '[path]'), $id);
		if ($isUnique > 0) {
			return self::createFailureJSONResponse('fail', 100, ['table.path_unique']);
		} else if (count($errors) > 0) {
			return self::createFailureJSONResponse('fail', 100, $this->getErrors($errors));
		} else {
			$pageService = $this->get('admin.service.page');
			try {
				$page = $pageRepo->findOneBy(['id' => $id]);
				if ($page === null) {
					return self::createFailureJSONResponse('fail');
				}
				/** @var Page $page */
				$pageService->save($page, $data);

				$data['id'] = $id;
			} catch (\Exception $e) {
				return self::createFailureJSONResponse('fail');
			}
		}

		return self::createSuccessJSONResponse($data, 'success');
	}

	/**
	 * 删除页面
	 *
	 * @Route("/delete", name="api.page.delete")
	 * @Method({"POST"})
	 * @param Request $request
	 * @return \Symfony\Component\HttpFoundation\JsonResponse
	 */
	public function deletePage(Request $request)
	{
		$data = $request->request->all();
		$accessor = PropertyAccess::createPropertyAccessor();
		$id = $accessor->getValue($data, '[id]');

		$em = $this->get('doctrine.orm.default_entity_manager');
		$pageRepo = $em->getRepository('Admin:Page');
		$page = $pageRepo->findOneBy(['id' => $id]);
		if ($page === null) {
			return self::createFailureJSONResponse('fail');
		}

		try {
			$em->remove($page);
			$em->flush();
		} catch (\Exception $e) {
			$em->rollback();
		}

		return self::createSuccessJSONResponse([], 'success');
	}
}