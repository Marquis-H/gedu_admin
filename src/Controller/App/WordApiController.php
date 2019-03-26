<?php
/**
 * Created by PhpStorm.
 * User: marquis
 * Date: 2019/2/3
 * Time: 10:34 PM
 */

namespace Admin\Controller\App;


use Admin\Entity\User;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use Util\Json;

/**
 * Class WordApiController
 * @package Admin\Controller\App
 */
class WordApiController extends AbstractAppController
{
	/**
	 * 单词数据
	 *
	 * @Route("/info", name="app.word.info")
	 * @Method({"GET"})
	 *
	 * @param Request $request
	 * @return \Symfony\Component\HttpFoundation\JsonResponse
	 */
	public function info(Request $request)
	{
		$wordService = $this->get('admin.service.word');
		/** @var User $user */
		$user = $this->getUser();
		$workType = ['ielts' => '雅思', 'toefl' => "托福", 'four' => '四级', 'six' => "六级", 'gre' => 'GRE', 'gmat' => 'GMAT'];

		// 是否有选择单词类型
		$isRecord = $wordService->isRecord($user);
		if ($isRecord === false) {
			return self::createSuccessJSONResponse(['info' => [
				'newWord' => '-',
				'nowWord' => '-',
				'surplusWord' => '-',
				'meWord' => '-',
			], 'isRecord' => $isRecord]);
		}

		// 获取单词数据
		$record = $wordService->recordInfo($user);
		return self::createSuccessJSONResponse([
			'info' => $record,
			'wordType' => $workType[$user->getWordType()],
			'isRecord' => true
		]);
	}

	/**
	 * 保存所选单词类型
	 *
	 * @Route("/create_record", name="app.word.create_record")
	 * @Method({"POST"})
	 *
	 * @param Request $request
	 * @return \Symfony\Component\HttpFoundation\JsonResponse
	 */
	public function saveWordRecord(Request $request)
	{
		$user = $this->getUser();
		$postData = Json::decode($request->getContent(), true);

		$wordService = $this->get('admin.service.word');
		try {
			$info = $wordService->saveRecord($user, $postData);

			return self::createSuccessJSONResponse([
				'info' => $info,
				'isRecord' => true
			]);
		} catch (\Exception $e) {
			return self::createFailureJSONResponse('无法选择');
		}
	}

	/**
	 * 获取单词信息
	 *
	 * @Route("/word_info", name="app.word.word_info")
	 * @Method({"GET"})
	 *
	 * @param Request $request
	 * @return \Symfony\Component\HttpFoundation\JsonResponse
	 */
	public function wordInfo(Request $request)
	{
		$user = $this->getUser();
		$index = $request->query->get('index');
		$isKnown = $request->query->get('isKnown');
		$wordService = $this->get('admin.service.word');
		try {
			$info = $wordService->getWordInfo($user, $index, $isKnown);

			return self::createSuccessJSONResponse($info);
		} catch (\Exception $e) {
			return self::createFailureJSONResponse('无法更新');
		}
	}

	/**
	 * 更新单词
	 *
	 * @Route("/update_record", name="app.word.update_record")
	 * @Method({"POST"})
	 *
	 * @param Request $request
	 * @return \Symfony\Component\HttpFoundation\JsonResponse
	 */
	public function updateWordRecord(Request $request)
	{
		$user = $this->getUser();
		$postData = Json::decode($request->getContent(), true);

		$wordService = $this->get('admin.service.word');
		try {
			$isEnd = $wordService->updateWordRecord($user, $postData);

			return self::createSuccessJSONResponse(['isEnd' => $isEnd]);
		} catch (\Exception $e) {
			return self::createFailureJSONResponse('无法更新');
		}
	}

	/**
	 * 打卡
	 *
	 * @Route("/daka", name="app.word.daka")
	 * @Method({"POST"})
	 *
	 * @param Request $request
	 * @return \Symfony\Component\HttpFoundation\JsonResponse
	 */
	public function dakaWord(Request $request)
	{
		/** @var User $user */
		$user = $this->getUser();
		$domain = $this->getParameter('domain');

		$wordService = $this->get('admin.service.word');
		try {
			$isComplete = $wordService->updateDaka($user);
			$static = $wordService->shareStaticData($user);

			// 分享图片的数据
			$shareData = [
				'avatar' => $user->getAvatar(),
				'nickname' => $user->getNickname(),
				'day' => $static['day'], // TODO 打卡累计天数
				'word' => $static['word'], // TODO 打卡的单词
				'shareImg' => $domain . '/images/share.jpeg',
				'type' => $user->getWordType()
			];

			return self::createSuccessJSONResponse(['isComplete' => $isComplete, 'shareData' => $shareData]);
		} catch (\Exception $e) {
			return self::createFailureJSONResponse('无法更新');
		}
	}
}