<?php
/**
 * Created by PhpStorm.
 * User: Marquis
 * Date: 2018/8/20
 * Time: 下午3:30
 */

namespace Admin\Controller\Api;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;

/**
 * Class SecurityController
 * @package Admin\Controller\Api
 */
class SecurityController extends AbstractApiController
{
	/**
	 * 登陆
	 *
	 * @Route("/login_check", name="api.auth.login_check")
	 * @Method({"POST"})
	 */
	public function login()
	{
	}

	/**
	 * 登出
	 *
	 * @Route("/logout", name="api.auth.logout")
	 * @return \Symfony\Component\HttpFoundation\JsonResponse
	 */
	public function logout()
	{
		return self::createSuccessJSONResponse();
	}
}