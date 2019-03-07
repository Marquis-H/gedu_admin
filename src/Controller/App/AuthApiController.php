<?php
/**
 * Created by PhpStorm.
 * User: marquis
 * Date: 2019/1/30
 * Time: 6:27 PM
 */

namespace Admin\Controller\App;

use Admin\Constants\Code;
use Admin\Constants\ValidateCodeScene;
use Admin\Entity\Token;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\PropertyAccess\PropertyAccess;
use Symfony\Component\Validator\Constraints\Callback;
use Symfony\Component\Validator\Constraints\Collection;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Context\ExecutionContextInterface;
use Util\Json;

/**
 * Class AuthApiController
 * @package Admin\Controller\App
 */
class AuthApiController extends AbstractAppController
{
	/**
	 * 获取到token
	 * @Route("/token", name="app.auth.token")
	 * @Method({"POST"})
	 *
	 * @param Request $request
	 * @return \Symfony\Component\HttpFoundation\JsonResponse
	 */
	public function genericToken(Request $request)
	{
		$accessor = PropertyAccess::createPropertyAccessor();
		$postData = Json::decode($request->getContent(), true);

		$em = $this->get('doctrine.orm.default_entity_manager');
		$phone = $accessor->getValue($postData, '[phone]');
		$user = $this->findUserByMobile($phone);
		if ($user instanceof JsonResponse) {
			return $user;
		}

		$jwtManager = $this->get('lexik_jwt_authentication.jwt_manager');
		// 设置identityField
		$jwtManager->setUserIdentityField('phone');
		$token = $jwtManager->create($user);
		$tokenBind = $em->getRepository('Admin:Token')->findOneBy(['User' => $user]);
		if ($tokenBind == null) {
			$tokenBind = new Token();
			$tokenBind->setUser($user);
		}
		$tokenBind->setToken($token);
		try {
			$em->persist($tokenBind);
			$em->flush();
		} catch (\Exception $e) {
			return self::createFailureJSONResponse(Code::getMessage(Code::SERVER_ERROR));
		}

		return self::createSuccessJSONResponse([
			'token' => $token
		]);
	}

	/**
	 * 申请绑定
	 * @Route("/bind_request", name="app.auth.bind_request")
	 * @Method({"POST"})
	 *
	 * @param Request $request
	 * @return JsonResponse
	 */
	public function bindRequest(Request $request)
	{
		$accessor = PropertyAccess::createPropertyAccessor();
		$postData = Json::decode($request->getContent(), true);
		$em = $this->get('doctrine.orm.default_entity_manager');

		$campusRepo = $em->getRepository('Admin:Campus');
		$constraints = new Collection([
			'campusId' => [
				new NotBlank(),
				new Callback(['callback' => function ($value, ExecutionContextInterface $context) use ($campusRepo) {
					$result = $campusRepo
						->findOneBy(['id' => $value]);
					if (null === $result) {
						$context->addViolation('校区不存在');
					}
				}])
			],
			'mobile' => [
				new NotBlank(['message' => '手机号码不能为空'])
			]
		]);

		$errors = $this->postDataValidate($postData, $constraints);
		if (count($errors) > 0) {
			return self::createFailureJSONResponse('fail', 100, $errors);
		} else {
			$phone = $accessor->getValue($postData, '[mobile]');

			$appUserService = $this->get('app.service.app_user');
			$exit = $appUserService->exist($phone);
			if ($exit > 0) {
				return self::createFailureJSONResponse('该账号已被绑定，如若非本人，请联系管理员');
			} else {
				$appUserService->producer(ValidateCodeScene::BIND, $phone);
				return self::createSuccessJSONResponse([], '验证码已发送');
			}
		}
	}

	/**
	 * 身份绑定
	 *
	 * @Route("/bind", name="api.auth.bind")
	 * @Method({"POST"})
	 *
	 * @param Request $request
	 * @return JsonResponse
	 */
	public function bind(Request $request)
	{
		$accessor = PropertyAccess::createPropertyAccessor();
		$postData = Json::decode($request->getContent(), true);

		$code = $accessor->getValue($postData, '[code]');
		$mobile = $accessor->getValue($postData, '[mobile]');
		$appUserService = $this->get('app.service.app_user');
		$status = $appUserService->consumer(ValidateCodeScene::BIND, $mobile, $code);
		// 验证码
		if ($status === true) {
			// 绑定
			$appUserService->bind($postData);

			return self::createSuccessJSONResponse([], '绑定成功');
		} else {
			return self::createFailureJSONResponse(Code::getMessage(Code::VALIDATE_CODE_ERROR));
		}
	}
}