<?php
/**
 * Created by PhpStorm.
 * User: marquis
 * Date: 2019/2/14
 * Time: 5:40 PM
 */

namespace Admin\Controller\Api;


use Admin\Entity\Word;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\PropertyAccess\PropertyAccess;
use Symfony\Component\Validator\Constraints\Collection;
use Util\Json;

/**
 * Class WordController
 * @package Admin\Controller\Api
 */
class WordController extends AbstractApiController
{
	/**
	 * 获取单词列表
	 *
	 * @Route("/list", name="api.word.list")
	 * @Method({"GET"})
	 *
	 * @param Request $request
	 * @return \Symfony\Component\HttpFoundation\JsonResponse
	 */
	public function wordList(Request $request)
	{
		$em = $this->get('doctrine.orm.default_entity_manager');
		$queryBuilder = $em
			->getRepository('Admin:Word')
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
		/** @var Word $item */
		foreach ($paginationResult['items'] as $item) {
			$tras = [];
			foreach ($item->getTranslation() as $value) {
				array_push($tras, $value['part'] . '【' . implode('、', $value['means']) . '】');
			}
			array_push($items, [
				'id' => $item->getId(),
				'word' => $item->getWord(),
				'rate' => $item->getRate(),
				'translation' => implode("\n", $tras),
				'enSymbol' => $item->getEnSymbol(),
				'usSymbol' => $item->getUsSymbol(),
				'annotation' => $item->getAnnotation() ? $item->getAnnotation() : '-',
				'tabs' => implode(',', $item->getTabs()),
				'originalTabs' => implode(',', $item->getTabs()),
				'edit' => false,
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
	 * 更新单词标签
	 *
	 * @Route("/update_tabs", name="api.word.update_tabs")
	 * @Method({"POST"})
	 *
	 * @param Request $request
	 * @return \Symfony\Component\HttpFoundation\JsonResponse
	 */
	public function updateWordTabs(Request $request)
	{
		$data = $request->request->all();
		$accessor = PropertyAccess::createPropertyAccessor();
		$em = $this->get('doctrine.orm.default_entity_manager');
		$wordRepo = $em->getRepository('Admin:Word');
		$id = $accessor->getValue($data, '[id]');

		$validator = $this->get('validator');
		$collectionConstraint = new Collection(
			[
				'tabs' => [],
			]
		);

		$errors = $validator->validate($data, $collectionConstraint);
		if (count($errors) > 0) {
			return self::createFailureJSONResponse('fail', 100, $this->getErrors($errors));
		} else {
			$wordService = $this->get('admin.service.word');
			try {
				$word = $wordRepo->findOneBy(['id' => $id]);
				if ($word === null) {
					return self::createFailureJSONResponse('fail');
				}
				/** @var Word $word */
				$wordService->saveTabs($word, $data);
			} catch (\Exception $e) {
				return self::createFailureJSONResponse('fail');
			}
		}

		return self::createSuccessJSONResponse($data, 'success');
	}


	/**
	 * 新增一组单词
	 *
	 * @Route("/add_word", name="app.word.add_word")
	 * @Method({"POST"})
	 *
	 * @param Request $request
	 * @return \Symfony\Component\HttpFoundation\JsonResponse
	 */
	public function addWord(Request $request)
	{
		$accessor = PropertyAccess::createPropertyAccessor();
		$id = $accessor->getValue($request->request->all(), '[id]');
		$em = $this->get('doctrine.orm.default_entity_manager');
		$wordUser = $em->getRepository('Admin:WordUser')->findOneBy(['id' => $id]);

		if ($wordUser === null) {
			return self::createFailureJSONResponse('更新失败');
		}

		$wordService = $this->get('admin.service.word');
		$newWord = $wordService->getWord($wordUser->getType());
		$wordUser->setAllWord(array_merge($wordUser->getAllWord(), $newWord));
		try {
			$em->persist($wordUser);
			$em->flush();
		} catch (\Exception $e) {
			return self::createFailureJSONResponse('更新失败');
		}

		return self::createSuccessJSONResponse(count($newWord));
	}
}