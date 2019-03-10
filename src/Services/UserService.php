<?php
/**
 * Created by PhpStorm.
 * User: marquis
 * Date: 2018/10/16
 * Time: 10:41 AM
 */

namespace Admin\Services;

use Admin\Constants\Reward;
use Admin\Entity\BackendUser;
use Admin\Entity\RewardLog;
use Admin\Entity\User;
use Psr\Container\ContainerInterface;
use Symfony\Component\DependencyInjection\ContainerAwareTrait;
use Symfony\Component\PropertyAccess\PropertyAccess;

/**
 * Class UserService
 * @package Admin\Services
 */
class UserService
{
	use ContainerAwareTrait;

	/**
	 * JWTEventListener constructor.
	 * @param ContainerInterface $container
	 */
	public function __construct(ContainerInterface $container)
	{
		$this->container = $container;
	}

	/**
	 * 保存用户信息
	 *
	 * @param BackendUser $backUser
	 * @param $data
	 * @return BackendUser
	 */
	public function save(BackendUser $backUser, $data)
	{
		$em = $this->container->get('doctrine.orm.default_entity_manager');
		$groupRepo = $em->getRepository('Admin:BackendGroup');
		$accessor = PropertyAccess::createPropertyAccessor();

		try {
			$backUser->setUsername($accessor->getValue($data, '[username]'));
			$backUser->setEmail($accessor->getValue($data, '[email]'));
			$password = $accessor->getValue($data, '[password]');
			if ($password) {
				$encodePassword = $this->container->get('security.password_encoder')->encodePassword($backUser, $password);
				$backUser->setPassword($encodePassword);
			}
			$backUser->setEnabled($accessor->getValue($data, '[isActive]') === 'true');
			$backUser->setIsSuperAdmin($accessor->getValue($data, '[isSuperAdmin]') === 'true');
			$backUser->setRoles(explode(',', $accessor->getValue($data, '[role]')));
			$backUser->setFirstname($accessor->getValue($data, '[firstname]'));
			$backUser->setLastname($accessor->getValue($data, '[lastname]'));

			$groups = explode(',', $accessor->getValue($data, '[group]'));
			foreach ($groups as $group) {
				$group = $groupRepo->findOneBy(['id' => $group]);
				$group && $backUser->addBackendGroup($group);
			}

			$em->persist($backUser);
			$em->flush();

			return $backUser;
		} catch (\Exception $exception) {
			$em->rollback();

			throw new \LogicException();
		}

	}

	/**
	 * 更新积分
	 *
	 * @param User $user
	 * @param $integral
	 * @param $reduceIntegral
	 * @param $messgae
	 */
	public function updateIntegral(User $user, $integral, $reduceIntegral, $messgae)
	{
		$em = $this->container->get('doctrine.orm.default_entity_manager');

		try {
			$user->setIntegral($integral);
			// 记录积分使用情况
			$rewardLog = new RewardLog();
			$rewardLog->setUser($user);
			$rewardLog->setIntegral($reduceIntegral);
			$rewardLog->setInfo($messgae);

			$em->persist($user);
			$em->persist($rewardLog);
			$em->flush();

		} catch (\Exception $e) {
			throw new \LogicException();
		}
	}

	/**
	 * 检查积分
	 *
	 * @param User $user
	 * @param $type
	 * @return bool
	 */
	public function isChangeIntegral(User $user, $type)
	{
		$em = $this->container->get('doctrine.orm.default_entity_manager');
		$parameterRepo = $em->getRepository('Admin:BackendParameter');
		$eachDayIntegral = $parameterRepo->findOneBy(['ck' => 'each_day_integral'])->getParameter();
		$shareIntegral = $parameterRepo->findOneBy(['ck' => 'share_integral'])->getParameter();
		$shareRegIntegral = $parameterRepo->findOneBy(['ck' => 'share_reg_integral'])->getParameter();
		$wordIntegral = $parameterRepo->findOneBy(['ck' => 'word_integral'])->getParameter();
		// 统计今日积分
		$infos = [Reward::SHARE_MESSAGE, Reward::SHARE_REG_MESSAGE, Reward::WORD_MESSAGE];
		/** @var RewardLog[] $rewardLog */
		$rewardLog = $em->getRepository('Admin:RewardLog')->findLogByDay(new \DateTime(), $infos);
		$dayReward = 0;
		foreach ($rewardLog as $value) {
			$dayReward = $dayReward + $value->getIntegral();
		}

		switch ($type) {
			case Reward::SHARE_MESSAGE:
				// 积分大于上限
				if ($dayReward + $shareIntegral > $eachDayIntegral) {
					return false;
				}
				self::updateIntegral($user, $user->getIntegral() + $shareIntegral, $shareIntegral, $type);
				break;
			case Reward::SHARE_REG_MESSAGE:
				// 积分大于上限
				if ($dayReward + $shareRegIntegral > $eachDayIntegral) {
					return false;
				}
				self::updateIntegral($user, $user->getIntegral() + $shareRegIntegral, $shareRegIntegral, $type);
				break;
			case Reward::WORD_MESSAGE:
				// 单词打卡
				if ($dayReward + $wordIntegral > $eachDayIntegral) {
					return false;
				}
				self::updateIntegral($user, $user->getIntegral() + $wordIntegral, $wordIntegral, $type);
		}

		return true;
	}
}