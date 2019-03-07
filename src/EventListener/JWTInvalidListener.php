<?php
/**
 * Created by PhpStorm.
 * User: marquis
 * Date: 2018/11/2
 * Time: 6:47 PM
 */

namespace Admin\EventListener;


use Lexik\Bundle\JWTAuthenticationBundle\Event\JWTExpiredEvent;
use Lexik\Bundle\JWTAuthenticationBundle\Event\JWTNotFoundEvent;
use Symfony\Component\DependencyInjection\ContainerAwareTrait;
use Symfony\Component\HttpFoundation\JsonResponse;

/**
 * Class JWTInvalidListener
 * @package Admin\EventListener
 */
class JWTInvalidListener
{
	/**
	 * @param JWTNotFoundEvent $event
	 */
	public function onJWTNotFound(JWTNotFoundEvent $event)
	{
		$res = new JsonResponse(['code' => 403, 'message' => '请重新登录'], 200);

		$event->setResponse($res);
	}

	/**
	 * @param JWTExpiredEvent $event
	 */
	public function onJWTExpired(JWTExpiredEvent $event)
	{
		$res = new JsonResponse(['code' => 401, 'message' => '请重新登录'], 200);

		$event->setResponse($res);
	}
}