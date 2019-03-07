<?php
/**
 * Created by PhpStorm.
 * User: marquis
 * Date: 2019/1/30
 * Time: 6:29 PM
 */

namespace Admin\Controller\App;

use Admin\Constants\Code;
use Admin\Controller\Api\AbstractApiController;
use Admin\Entity\User;
use Symfony\Component\Validator\Constraints\Collection;
use Util\Json;

/**
 * Class AbstractAppController
 * @package Admin\Controller\App
 */
class AbstractAppController extends AbstractApiController
{
	/**
	 * 查找用户
	 *
	 * @param $mobile
	 * @return User|\Symfony\Component\HttpFoundation\JsonResponse
	 */
	protected function findUserByMobile($mobile)
	{
		$em = $this->get('doctrine.orm.default_entity_manager');
		/** @var User $user */
		$user = $em->getRepository('Admin:User')->findOneBy([
			'phone' => $mobile
		]);
		if ($mobile === null) {
			return $this->createFailureJSONResponse(Code::getMessage(Code::INVALID_REQUEST_DATA), Code::INVALID_REQUEST_DATA);
		}
		//不存在(账号或未绑定)
		if ($user === null || $user->getWechatBinding() === null) {
			return $this->createFailureJSONResponse(Code::getMessage(Code::USER_NOT_EXIST), Code::USER_NOT_EXIST);
		}
		//被禁用
		if ($user->getEnable() == false) {
			return $this->createFailureJSONResponse(Code::getMessage(Code::USER_DISABLE), Code::USER_DISABLE);
		}

		return $user;
	}

	/**
	 * 提交数据验证
	 *
	 * @param array $data
	 * @param Collection $constraints
	 * @return array
	 */
	protected function postDataValidate(array $data, Collection $constraints)
	{
		$errors = $this->get('validator')->validate($data, $constraints);
		if ($errors->count() > 0) {
			$data = [];
			if (count($errors) > 0) {
				foreach ($errors as $error) {
					/** @var \Symfony\Component\Validator\ConstraintViolation $error */
					array_push($data, $error->getMessage());
				}
			}
			return $data;
		}

		return [];
	}

	/**
	 * 解析请求body中的json数据
	 *
	 * @param string $content
	 *
	 * @return array
	 */
	protected function getRequestJSONData($content)
	{
		$data = Json::decode($content, true);
		return is_array($data) ? $data : [];
	}
}