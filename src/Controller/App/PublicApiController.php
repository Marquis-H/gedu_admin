<?php
/**
 * Created by PhpStorm.
 * User: marquis
 * Date: 2019/1/30
 * Time: 5:32 PM
 */

namespace Admin\Controller\App;

use Admin\Constants\Code;
use Admin\Constants\Reward;
use Admin\Entity\Content;
use Admin\Entity\User;
use Admin\Entity\WechatBinding;
use Admin\Repository\WechatBindingRepository;
use GuzzleHttp\Client;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\PropertyAccess\PropertyAccess;
use Util\Json;

/**
 * Class PublicApiController
 * @package Admin\Controller\App
 */
class PublicApiController extends AbstractAppController
{
	/**
	 * @var string
	 */
	private $homeBannerSlug = 'home';

	/**
	 * 获取校区列表
	 *
	 * @Route("/campus", name="app.campus.get_list")
	 * @Method({"GET"})
	 *
	 * @param Request $request
	 * @return \Symfony\Component\HttpFoundation\JsonResponse
	 */
	public function getCampus(Request $request)
	{
		$em = $this->get('doctrine.orm.default_entity_manager');
		$campus = $em->getRepository('Admin:Campus')->findAll();

		$data = [];
		foreach ($campus as $value) {
			array_push($data, [
				'label' => $value->getTitle(),
				'value' => $value->getId()
			]);
		}

		return self::createSuccessJSONResponse($data, 'success');
	}

	/**
	 * 获取openId
	 *
	 * @Route("/get_openId", name="app.user.get_openId")
	 * @Method({"POST"})
	 *
	 * @param Request $request
	 * @return \Symfony\Component\HttpFoundation\JsonResponse
	 */
	public function getOpenId(Request $request)
	{
		$postData = $this->getRequestJSONData($request->getContent());
		$accessor = PropertyAccess::createPropertyAccessor();
		$code = $accessor->getValue($postData, '[code]');
		// 换取openId
		$openId = $this->openId($code);

		if ($openId == null) {
			return self::createFailureJSONResponse('无法登陆');
		}

		// 获取手机号
		$em = $this->get('doctrine.orm.default_entity_manager');
		/** @var WechatBindingRepository $wechatBindRepo */
		$wechatBindRepo = $em->getRepository('Admin:WechatBinding');
		$wechatBind = $wechatBindRepo->findPhoneByOpenId($openId);
		if (empty($wechatBind)) {
			$phone = '';
		} else {
			$phone = $wechatBind[0]['phone'];
		}

		return self::createSuccessJSONResponse([
			'openId' => $openId,
			'phone' => $phone
		]);
	}


	/**
	 * 获取banner
	 *
	 * @Route("/banner", name="app.banner.list")
	 * @Method({"GET"})
	 *
	 * @param Request $request
	 * @return \Symfony\Component\HttpFoundation\JsonResponse
	 */
	public function banner(Request $request)
	{
		$em = $this->get('doctrine.orm.default_entity_manager');
		$openId = $request->query->get('openId');
		$type = $request->query->get('type');
		$code = $request->query->get('code');
		$wechatBindRepo = $em->getRepository('Admin:WechatBinding');
		$userRepo = $em->getRepository('Admin:User');
		$banners = $em->getRepository('Admin:Banner')->findBy(['slug' => $type ? $type : $this->homeBannerSlug]);

		$domain = $this->getParameter('domain');
		$data = [];
		foreach ($banners as $banner) {
			$user = null;
			if ($openId) {
				/** @var WechatBinding $wechatBind */
				$wechatBind = $wechatBindRepo->findUserByOpenId($openId);
				if ($wechatBind) {
					$user = $wechatBind->getUser();
				} else if ($code) {
					$user = $userRepo->findOneBy(['invitationCode' => $code]);
				}
			}
			if ($user) {
				$campus = $user->getCampus();
				if ($campus->getId() === $banner->getCampus()->getId()) {
					array_push($data, $domain . $banner->getPhoto());
				}
			} else {
				array_push($data, $domain . $banner->getPhoto());
			}
		}

		return self::createSuccessJSONResponse($data, 'success');
	}

	/**
	 * 获取文章类别
	 *
	 * @Route("/content_cat", name="app.content_cat.list")
	 * @Method({"GET"})
	 *
	 * @param Request $request
	 * @return \Symfony\Component\HttpFoundation\JsonResponse
	 */
	public function contentCatList(Request $request)
	{
		$domain = $this->getParameter('domain');
		$openId = $request->query->get('openId');
		$em = $this->get('doctrine.orm.default_entity_manager');
		$contentCat = $em->getRepository('Admin:ContentCat')->findAll();
		$wechatBindRepo = $em->getRepository('Admin:WechatBinding');
		$data = [];
		foreach ($contentCat as $value) {
			$catId = $value->getId();
			$contents = $em->getRepository('Admin:Content')->findByCat($catId);
			$contentData = [];
			/** @var Content $content */
			foreach ($contents as $content) {
				$user = null;
				if ($openId) {
					/** @var WechatBinding $wechatBind */
					$wechatBind = $wechatBindRepo->findUserByOpenId($openId);
					/** @var User $user */
					$user = $wechatBind ? $wechatBind->getUser() : null;
				}
				if ($user) {
					$campus = $user->getCampus();
					if ($campus->getId() === $content->getCampus()->getId()) {
						array_push($contentData, [
							'id' => $content->getId(),
							'title' => $content->getTitle(),
							'desc' => $content->getSummary(),
							'thumb' => $domain . $content->getPhoto()
						]);
					}
				} else {
					array_push($contentData, [
						'id' => $content->getId(),
						'title' => $content->getTitle(),
						'desc' => $content->getSummary(),
						'thumb' => $domain . $content->getPhoto()
					]);
				}
			}
			array_push($data, [
				'id' => $value->getId(),
				'title' => $value->getTitle(),
				'slug' => $value->getSlug(),
				'contents' => $contentData
			]);
		}

		return self::createSuccessJSONResponse($data, 'success');
	}

	/**
	 * 获取文章列表
	 *
	 * @Route("/content/list", name="app.content.list")
	 * @Method({"GET"})
	 *
	 * @param Request $request
	 * @return \Symfony\Component\HttpFoundation\JsonResponse
	 */
	public function contentList(Request $request)
	{
		$domain = $this->getParameter('domain');
		$catId = $request->query->get('cat');
		$em = $this->get('doctrine.orm.default_entity_manager');
		$contents = $em->getRepository('Admin:Content')->findByCat($catId);

		$data = [];
		/** @var Content $content */
		foreach ($contents as $content) {
			array_push($data, [
				'id' => $content->getId(),
				'title' => $content->getTitle(),
				'desc' => $content->getSummary(),
				'thumb' => $domain . $content->getPhoto()
			]);
		}

		return self::createSuccessJSONResponse($data, 'success');
	}

	/**
	 * 获取文章内容
	 *
	 * @Route("/content/detail", name="app.content.detail")
	 * @Method({"GET"})
	 *
	 * @param Request $request
	 * @return \Symfony\Component\HttpFoundation\JsonResponse
	 */
	public function contentDetail(Request $request)
	{
		$id = $request->query->get('id');
		$type = $request->query->get('type');
		$accessor = PropertyAccess::createPropertyAccessor();
		$em = $this->get('doctrine.orm.default_entity_manager');
		$content = $em->getRepository('Admin:Content')->findOneBy(['id' => $id]);
		if ($content === null) {
			return self::createFailureJSONResponse('无法获取文件内容');
		}

		$data = [
			'title' => $content->getTitle(),
			'content' => $content->getContent(),
			'extra' => []
		];
		switch ($type) {
			case 'campus': // 校区的额外信息
				$extraData = explode(',', $content->getExtra());
				foreach ($extraData as $value) {
					$extra = explode('|', $value);
					array_push($data['extra'], [
						'title' => $accessor->getValue($extra, '[0]'),
						'phone' => $accessor->getValue($extra, '[1]'),
						'address' => $accessor->getValue($extra, '[2]'),
						'map' => $accessor->getValue($extra, '[3]')
					]);
				}
				break;
		}

		return self::createSuccessJSONResponse($data, 'success');
	}

	/**
	 * 获取奖品列表
	 *
	 * @Route("/prize/list", name="app.prize.list")
	 * @Method({"GET"})
	 *
	 * @param Request $request
	 * @return \Symfony\Component\HttpFoundation\JsonResponse
	 */
	public function prizeList(Request $request)
	{
		$domain = $this->getParameter('domain');
		$em = $this->get('doctrine.orm.default_entity_manager');

		$prizes = $em->getRepository('Admin:Prize')->findAll();
		$data = [];
		foreach ($prizes as $prize) {
			$campus = $prize->getCampus()->getTitle();
			$data[$campus][] = [
				'title' => $prize->getTitle(),
				'num' => $prize->getIntegral(),
				'photo' => $domain . $prize->getPhoto()
			];
		}

		return self::createSuccessJSONResponse($data, 'success');
	}

	/**
	 * 更新分享的积分
	 *
	 * @Route("/update_share_integral", name="app.integral_share.update")
	 * @Method({"POST"})
	 *
	 * @param Request $request
	 * @return \Symfony\Component\HttpFoundation\JsonResponse
	 */
	public function updateShareIntegral(Request $request)
	{
		$postData = $this->getRequestJSONData($request->getContent());
		$accessor = PropertyAccess::createPropertyAccessor();

		$code = $accessor->getValue($postData, '[code]');
		$openId = $accessor->getValue($postData, '[openId]');
		$em = $this->get('doctrine.orm.default_entity_manager');
		// 检查openId是否有绑定
		/** @var WechatBinding $wechatBind */
		$wechatBind = $em->getRepository('Admin:WechatBinding')->findUserByOpenId($openId);
		$user = $wechatBind ? $wechatBind->getUser() : null;
		if ($user) {
			// 当前用户点击
			if ($code === null || $user->getInvitationCode() === $code) {
				return self::createSuccessJSONResponse([
					'code' => $user->getInvitationCode(),
					'isBind' => true
				]);
			}
			// 已经绑定的用户, 不计入积分
			if ($user->getInvitationCode() !== $code) {
				return self::createSuccessJSONResponse([
					'code' => $user->getInvitationCode(),
					'isBind' => true
				]);
			}

			return self::createSuccessJSONResponse([
				'isBind' => true
			]);
		} else {
			// 计入积分
			$userService = $this->get('admin.service.user');
			$bindUser = $em->getRepository('Admin:User')->findOneBy(['invitationCode' => $code]);
			$userService->isChangeIntegral($bindUser, Reward::SHARE_MESSAGE);

			return self::createSuccessJSONResponse([
				'code' => $bindUser->getInvitationCode(),
				'isBind' => false
			]);
		}
	}

	/**
	 * 通过code解析出openId
	 *
	 * @param $code
	 * @return null
	 */
	private function openId($code)
	{
		$client = new Client();
		$response = $client->get(sprintf('https://api.weixin.qq.com/sns/jscode2session?appid=%s&secret=%s&js_code=%s&grant_type=authorization_code',
			'wx0ab847ab3d4e9e59', 'a895e66b8ab4f859180b9f96347d22db', $code));

		$accessor = PropertyAccess::createPropertyAccessor();
		if ($response->getStatusCode() == 200) {
			$content = Json::decode($response->getBody(), true);
			$openId = $accessor->getValue($content, '[openid]');
			if ($openId) {
				return $openId;
			}
		}

		return null;
	}
}