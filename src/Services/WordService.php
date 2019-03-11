<?php
/**
 * Created by PhpStorm.
 * User: marquis
 * Date: 2019/2/13
 * Time: 3:43 PM
 */

namespace Admin\Services;


use Admin\Constants\Reward;
use Admin\Entity\User;
use Admin\Entity\Word;
use Admin\Entity\WordUser;
use Admin\Entity\WordUserLog;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\PropertyAccess\PropertyAccess;

/**
 * Class WordService
 * @package Admin\Services
 */
class WordService
{
	/**
	 * @var int
	 */
	protected $newWordNum = 80;

	/** @var ContainerInterface */
	private $container;

	/**
	 * WordService constructor.
	 * @param ContainerInterface $container
	 */
	public function __construct(ContainerInterface $container)
	{
		$this->container = $container;
	}

	/**
	 * 保存标签
	 *
	 * @param Word $word
	 * @param $data
	 * @return Word
	 */
	public function saveTabs(Word $word, $data)
	{
		$accessor = PropertyAccess::createPropertyAccessor();
		$em = $this->container->get('doctrine.orm.default_entity_manager');

		try {
			$word->setTabs(explode(',', $accessor->getValue($data, '[tabs]')));

			$em->persist($word);
			$em->flush();

			return $word;
		} catch (\Exception $e) {
			$em->rollback();

			throw new \LogicException();
		}
	}

	/**
	 * 判断是否有选择单词类型
	 *
	 * @param User $user
	 * @return bool
	 */
	public function isRecord(User $user)
	{
		$em = $this->container->get('doctrine.orm.default_entity_manager');
		$wordUser = $em->getRepository('Admin:WordUser')->findOneBy(['User' => $user, 'isSelect' => true]);
		if ($wordUser === null) {
			return false;
		}

		return true;
	}

	/**
	 * 获取单词数据
	 *
	 * @param User $user
	 * @return array
	 */
	public function recordInfo(User $user)
	{
		$em = $this->container->get('doctrine.orm.default_entity_manager');
		/** @var WordUser $wordUser */
		$wordUser = $em->getRepository('Admin:WordUser')->findOneBy(['User' => $user, 'isSelect' => true]);
		if ($wordUser === null) {
			return [];
		}

		$wordUserLogRepo = $em->getRepository('Admin:WordUserLog');
		// 检查记录
		$now = new \DateTime();
		// 查找是否有当天记录
		$workUserLog = $wordUserLogRepo->findByDate($wordUser->getId(), $now->format('Y-m-d'));
		if ($workUserLog === null) { // 不存在当天记录
			/** @var WordUserLog $lastWordUserLog */
			$lastWordUserLog = $wordUserLogRepo->findByLast($wordUser->getId());
			// 上一天未完成
			if ($lastWordUserLog->getIsComplete() == false) {
				$lastKnownWord = $lastWordUserLog->getKnownWord();
				// 更新wordUser
				$wordUser->setSurplusWord(array_merge($lastKnownWord, $wordUser->getSurplusWord()));
				$lastWordUserLog->setKnownWord([]);
				$wordUser->setNewWord([]);
			} else {
				// 分配新单词
				$meWordNum = count($wordUser->getMeWord());
				$allWord = $wordUser->getAllWord();
				$newWords = [];
				$i = $meWordNum;
				while ($i < ($this->newWordNum + $meWordNum)) {
					array_push($newWords, $allWord[$meWordNum]);
					$i++;
				}
				$wordUser->setNewWord($newWords);
				$wordUser->setNowWord($newWords);
				$wordUser->setSurplusWord($newWords);
				$meWord = $wordUser->getMeWord();
				// 记录到我的单词
				$wordUser->setMeWord(array_merge($meWord, $newWords));
			}
			// 单词记录（每日）
			$wordUserLog = new WordUserLog();
			$wordUserLog->setIsComplete(false);
			$wordUserLog->setKnownWord([]);
			$wordUserLog->setWordUser($wordUser);
			try {
				$em->persist($wordUser);
				$em->persist($wordUserLog);
				$em->persist($lastWordUserLog);
				$em->flush();
			} catch (\Exception $e) {
				throw new \LogicException();
			}
		}

		// 获取数据
		$newWord = $wordUser->getNewWord();
		$nowWord = $wordUser->getNowWord();
		$surplusWord = $wordUser->getSurplusWord();
		$meWord = $wordUser->getMeWord();

		return [
			'newWord' => count($newWord),
			'nowWord' => count($nowWord),
			'surplusWord' => count($surplusWord),
			'meWord' => count($meWord)
		];
	}

	/**
	 * 创建单词记录
	 *
	 * @param User $user
	 * @param $data
	 * @return array
	 */
	public function saveRecord(User $user, $data)
	{
		$accessor = PropertyAccess::createPropertyAccessor();
		$em = $this->container->get('doctrine.orm.default_entity_manager');
		$type = $accessor->getValue($data, '[type]');
		$wordUser = $em->getRepository('Admin:WordUser')->findOneBy(['User' => $user, 'type' => $type]);
		// 已存在改类型单词本
		if ($wordUser !== null) {
			return [];
		}

		// 创建单词记录
		$words = self::getWord($type);
		$newWords = [];
		$i = 0;
		while ($i < $this->newWordNum) {
			array_push($newWords, $words[$i]);
			$i++;
		}
		$wordUser = new WordUser();
		$wordUser->setUser($user);
		$wordUser->setAllWord($words);
		$wordUser->setMeWord($newWords);
		$wordUser->setSurplusWord($newWords);
		$wordUser->setNowWord($newWords);
		$wordUser->setNewWord($newWords);
		$wordUser->setIsSelect(true);
		$wordUser->setType($type);

		// 单词记录（每日）
		$wordUserLog = new WordUserLog();
		$wordUserLog->setIsComplete(false);
		$wordUserLog->setKnownWord([]);
		$wordUserLog->setWordUser($wordUser);
		try {
			$em->persist($wordUser);
			$em->persist($wordUserLog);
			$em->flush();
		} catch (\Exception $e) {
			throw new \LogicException();
		}

		return [
			'newWord' => count($newWords),
			'nowWord' => count($newWords),
			'surplusWord' => count($newWords),
			'meWord' => count($newWords),
		];
	}

	/**
	 * 获取单词信息
	 *
	 * @param User $user
	 * @param $index
	 * @param $isKnown
	 * @return array|bool
	 */
	public function getWordInfo(User $user, $index, $isKnown)
	{
		$em = $this->container->get('doctrine.orm.default_entity_manager');
		$wordUser = $em->getRepository('Admin:WordUser')->findOneBy(['User' => $user, 'isSelect' => true]);
		// 已存在改类型单词本
		if ($wordUser === null) {
			return false;
		}

		$wordUserLogRepo = $em->getRepository('Admin:WordUserLog');
		// 检查记录
		$now = new \DateTime();
		// 查找是否有当天记录
		/** @var WordUserLog $wordUserLog */
		$wordUserLog = $wordUserLogRepo->findByDate($wordUser->getId(), $now->format('Y-m-d'));
		// 打卡
		if (count($wordUser->getSurplusWord()) == 0 && $wordUserLog->getIsComplete() == false) {
			return ['isEnd' => true];
		}
		// 今日已打卡
		if (count($wordUser->getSurplusWord()) == 0 && $wordUserLog->getIsComplete() == true) {
			return ['isComplete' => true];
		}

		$nowWord = $wordUser->getNowWord();
		$surplusWord = $wordUser->getSurplusWord();
		// 剩余未完成
		if ($index >= count($surplusWord)) {
			return ['again' => true];
		}
		$word = $surplusWord[$index];
		$word = $em->getRepository('Admin:Word')->findOneBy(['word' => $word]);
		$tras = [];
		foreach ($word->getTranslation() as $value) {
			array_push($tras, $value['part'] . '【' . implode('、', $value['means']) . '】');
		}
		// 当前单词位置
		if ($index == 0) {
			$currentValue = count($nowWord) - count($surplusWord);
		} else {
			$currentValue = $isKnown + 1;
		}

		return [
			'word' => $word->getWord(),
			'symbol' => $word->getEnSymbol() ? $word->getEnSymbol() : $word->getUsSymbol(),
			'voice' => $word->getEnMp3() ? $word->getEnMp3() : $word->getUsMp3(),
			'translation' => implode(',', $tras),
			'annotation' => $word->getAnnotation() ? $word->getAnnotation() : '-',
			'exchanges' => $word->getExchanges() ? implode(',', $word->getExchanges()) : '-',
			'currentValue' => $currentValue
		];
	}

	/**
	 * 更新单词记录
	 *
	 * @param User $user
	 * @param $postData
	 * @return bool
	 */
	public function updateWordRecord(User $user, $postData)
	{
		$accessor = PropertyAccess::createPropertyAccessor();
		$em = $this->container->get('doctrine.orm.default_entity_manager');
		$wordUser = $em->getRepository('Admin:WordUser')->findOneBy(['User' => $user, 'isSelect' => true]);
		// 已存在改类型单词本
		if ($wordUser === null) {
			return false;
		}

		// 获取到
		$index = $accessor->getValue($postData, '[index]');
		$isKnown = $accessor->getValue($postData, '[isKnown]');
		if ($isKnown) {
			$surplusWord = $wordUser->getSurplusWord();
			$word = $accessor->getValue($surplusWord, '[' . $index . ']');
			// 判断word 是否为最后一个
			if ($word === null && count($surplusWord) == 0) {
				return true;
			}
			// 去除单词
			array_splice($surplusWord, $index, 1);
			$wordUser->setSurplusWord($surplusWord);
			// 加入记录
			$wordUserLogRepo = $em->getRepository('Admin:WordUserLog');
			// 检查记录
			$now = new \DateTime();
			// 查找是否有当天记录
			/** @var WordUserLog $wordUserLog */
			$wordUserLog = $wordUserLogRepo->findByDate($wordUser->getId(), $now->format('Y-m-d'));
			$knowWord = $wordUserLog->getKnownWord();
			array_push($knowWord, $word);
			$wordUserLog->setKnownWord($knowWord);
			try {
				$em->persist($wordUser);
				$em->persist($wordUserLog);
				$em->flush();

				// 最后一个单词
				if (count($surplusWord) == 0) {
					return true;
				}
			} catch (\Exception $e) {
			}
		}

		return false;
	}

	public function updateDaka(User $user)
	{
		$em = $this->container->get('doctrine.orm.default_entity_manager');
		$wordUser = $em->getRepository('Admin:WordUser')->findOneBy(['User' => $user, 'isSelect' => true]);
		// 已存在改类型单词本
		if ($wordUser === null) {
			return false;
		}

		$wordUserLogRepo = $em->getRepository('Admin:WordUserLog');
		// 检查记录
		$now = new \DateTime();
		// 查找是否有当天记录
		/** @var WordUserLog $wordUserLog */
		$wordUserLog = $wordUserLogRepo->findByDate($wordUser->getId(), $now->format('Y-m-d'));
		$wordUserLog->setIsComplete(true);

		// 记录到我的单词
		$wordUser->setNewWord([]);
		$wordUser->setNowWord([]);

		// 积分统计
		$userService = $this->container->get('admin.service.user');
		$userService->isChangeIntegral($user, Reward::WORD_MESSAGE);

		try {
			$em->persist($wordUser);
			$em->persist($wordUserLog);
			$em->flush();
		} catch (\Exception $e) {
			throw new \LogicException($e->getMessage());
		}

		return true;
	}

	/**
	 * 获取同一类型的单词
	 *
	 * @param $type
	 * @return mixed
	 */
	public function getWord($type)
	{
		$em = $this->container->get('doctrine.orm.default_entity_manager');
		$words = $em->getRepository('Admin:Word')->findByType($type);

		$data = [];
		/** @var Word $word */
		foreach ($words as $word) {
			array_push($data, $word['word']);
		}

		// 打乱单词
		shuffle($data);

		return $data;
	}
}