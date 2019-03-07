<?php
/**
 * Created by PhpStorm.
 * User: marquis
 * Date: 2019/1/31
 * Time: 6:55 PM
 */

namespace Admin\Services;


use Admin\Entity\User;
use Admin\Entity\WechatBinding;
use Predis\Client;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\PropertyAccess\PropertyAccess;
use Util\Str;

/**
 * Class AppUserService
 * @package Admin\Services
 */
class AppUserService
{
	/** 验证码过期时间(分钟) */
	const EXPRIE_MINUTE = 10;

	/** @var ContainerInterface */
	private $container;

	/** @var \Redis */
	private $redis;

	/**
	 * AppUserService constructor.
	 * @param ContainerInterface $container
	 */
	public function __construct(ContainerInterface $container)
	{
		$this->container = $container;
		$this->redis = new \Redis();
		$this->redis->connect('127.0.0.1');
	}

	/**
	 * 保存APP用户（后台）
	 *
	 * @param User $user
	 * @param $data
	 * @param $isCreate
	 * @return User
	 */
	public function saveBackend(User $user, $data, $isCreate = false)
	{
		$accessor = PropertyAccess::createPropertyAccessor();
		$em = $this->container->get('doctrine.orm.default_entity_manager');

		try {
			$user->setName($accessor->getValue($data, '[name]'));
			$user->setGender($accessor->getValue($data, '[gender]'));
			$accessor->getValue($data, '[birthday]') && $user->setBirthday(new \DateTime($accessor->getValue($data, '[birthday]')));
			$user->setPhone($accessor->getValue($data, '[phone]'));
			//保存校区
			$campusId = $accessor->getValue($data, '[campusId]');
			$campus = $em->getRepository('Admin:Campus')->findOneBy(['id' => $campusId]);
			$user->setCampus($campus);
			//开启账户
			$user->setEnable($accessor->getValue($data, '[isEnable]'));
			if ($isCreate) {
				//generic邀请码
				$code = Str::randomStr(12);
				$user->setInvitationCode($code);
			}
			//学员
			$user->setIsMember($accessor->getValue($data, '[isMember]'));

			$em->persist($user);
			$em->flush();

			return $user;
		} catch (\Exception $e) {
			$em->rollback();

			throw new \LogicException();
		}
	}

	/**
	 * 前台保存用户数据
	 *
	 * @param $data
	 */
	public function bind($data)
	{
		$accessor = PropertyAccess::createPropertyAccessor();
		$openId = $accessor->getValue($data, '[openId]');
		$mobile = $accessor->getValue($data, '[mobile]');
		$campusId = $accessor->getValue($data, '[campusId]');

		$em = $this->container->get('doctrine.orm.default_entity_manager');
		$user = $em->getRepository('Admin:User')->findOneBy(['phone' => $mobile]);
		$campus = $em->getRepository('Admin:Campus')->findOneBy(['id' => $campusId]);
		if ($user === null) {
			$user = new User();
			$user->setPhone($mobile);
			$user->setName($accessor->getValue($data, '[nickname]'));
			$user->setEnable(true);
			$user->setCampus($campus);
			//generic邀请码
			$code = Str::randomStr(12);
			$user->setInvitationCode($code);
		}
		$user->setAvatar($accessor->getValue($data, '[avatar]'));
		$user->setNickname($accessor->getValue($data, '[nickname]'));
		$wechatBind = new WechatBinding();
		$wechatBind->setOpenid($openId);
		$user->setWechatBinding($wechatBind);

		try {
			$em->persist($user);
			$em->flush();
		} catch (\Exception $e) {
			throw new \LogicException();
		}
	}

	/**
	 * 检查是否有绑定
	 *
	 * @param $phone
	 * @return int
	 */
	public function exist($phone)
	{
		$em = $this->container->get('doctrine.orm.default_entity_manager');
		$userRepo = $em->getRepository('Admin:User');
		$user = $userRepo->createQueryBuilder('q')
			->select('q')
			->leftJoin('q.wechatBinding', 'w')
			->where('q.phone = :phone')
			->andWhere('w.id is not null')
			->setParameter('phone', $phone)
			->getQuery()
			->getResult();

		return count($user);
	}

	/**
	 * 产生验证码
	 *
	 * @param $scene
	 * @param $phone
	 * @return string
	 */
	public function producer($scene, $phone)
	{
		$code = self::generateCode();
		$service = $this->container->get('app.service.sms');
		$service->sendMessage($phone, 'IOqTF4', ['code' => $code, 'exprie_minute' => self::EXPRIE_MINUTE]);

		$this->redis->setex($this->getCacheKey($scene, $phone), 60 * self::EXPRIE_MINUTE, $code);
		return $code;
	}

	/**
	 * 消费验证码
	 *
	 * @param $scene
	 * @param $mobile
	 * @param $code
	 * @return bool
	 */
	public function consumer($scene, $mobile, $code)
	{
		$key = $this->getCacheKey($scene, $mobile);
		$result = $this->redis->get($key);
		if (!is_null($result) && (string)$result === (string)$code) {
			$this->redis->delete($key);
			return true;
		} else {
			return false;
		}
	}


	/**
	 * 产生验证码
	 *
	 * @param int $length
	 *
	 * @return string
	 */
	static public function generateCode(int $length = 6)
	{
		$result = '';
		for ($i = 0; $i < $length; $i++) {
			$result .= mt_rand(0, 9);
		}
		return $result;
	}

	/**
	 * 获取验证码缓存键
	 *
	 * @param string $scene
	 * @param string $mobile
	 *
	 * @return string
	 */
	protected function getCacheKey($scene, $mobile)
	{
		return sprintf(':validate_code:%s:%s', $scene, $mobile);
	}
}