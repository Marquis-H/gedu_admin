<?php
/**
 * Created by PhpStorm.
 * User: marquis
 * Date: 2019/2/1
 * Time: 5:31 PM
 */

namespace Admin\Controller\App;


use Admin\Entity\User;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\PropertyAccess\PropertyAccess;
use Util\Json;

/**
 * Class ProfileApiController
 * @package Admin\Controller\App
 */
class ProfileApiController extends AbstractAppController
{
	/**
	 * @Route("/detail", name="api.profile.detail")
	 * @Method({"GET"})
	 *
	 * @param Request $request
	 * @return \Symfony\Component\HttpFoundation\JsonResponse
	 */
	public function profile(Request $request)
	{
		/** @var User $user */
		$user = $this->getUser();
		// 获取个人数据
		$static = [
			'integral' => $user->getIntegral(),
			'daka' => 0,
			'word' => 0
		];
		return self::createSuccessJSONResponse([
			'id' => $user->getId(),
			'avatar' => $user->getAvatar(),
			'nickname' => $user->getNickname(),
			'name' => $user->getName(),
			'gender' => $user->getGender(),
			'birthday' => $user->getBirthday() ? $user->getBirthday()->format('Y-m-d') : null,
			'phone' => $user->getPhone(),
			'campus' => $user->getCampus()->getTitle(),
			'code' => $user->getInvitationCode(),
			'static' => $static,
			'wordType' => $user->getWordType()
		], 'success');
	}

	/**
	 * @Route("/update", name="api.profile.update")
	 * @Method({"POST"})
	 *
	 * @param Request $request
	 * @return \Symfony\Component\HttpFoundation\JsonResponse
	 */
	public function updateProfile(Request $request)
	{
		/** @var User $user */
		$user = $this->getUser();
		$accessor = PropertyAccess::createPropertyAccessor();
		$postData = Json::decode($request->getContent(), true);
		$type = $postData['type'];

		$em = $this->get('doctrine.orm.default_entity_manager');
		$profile = $em->getRepository('Admin:User')->findOneBy(['id' => $user->getId()]);

		if ($profile === null) {
			return self::createFailureJSONResponse('no profile');
		}

		switch ($type) {
			case 'name':
				$profile->setName($accessor->getValue($postData, '[name]'));
				break;
			case 'gender':
				$profile->setGender($accessor->getValue($postData, '[gender]'));
				break;
			case 'birthday':
				$profile->setBirthday(new \DateTime($accessor->getValue($postData, '[birthday]')));
				break;
			case 'wordType':
				$wordType = $accessor->getValue($postData, '[wordType]');
				$profile->setWordType($wordType);
				// 单词打卡记录
				$wordService = $this->get('admin.service.word');
				$isWordUserType = $wordService->isWordUserType($profile);
				if($isWordUserType === false){
					$wordService->saveRecord($profile, ['type' => $wordType]);
				}
		}

		try {
			$em->persist($profile);
			$em->flush();

		} catch (\Exception $e) {
			return self::createFailureJSONResponse('error');
		}

		return self::createSuccessJSONResponse([], '更新成功');
	}
}