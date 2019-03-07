<?php
namespace Admin\EventListener;

/**
 * Created by PhpStorm.
 * User: Marquis
 * Date: 2018/8/28
 * Time: 下午5:57
 */
use Symfony\Component\HttpKernel\Event\GetResponseEvent;
use Util\Json;

/**
 * Class RequestListener
 * @package Admin\EventListener
 */
class RequestListener
{
	/**
	 * @param GetResponseEvent $event
	 */
	public function onKernelRequest(GetResponseEvent $event)
	{
		if (!$event->isMasterRequest()) {
			return;
		}

		$request = $event->getRequest();

		if ($request->isMethod('POST') && strpos($request->headers->get('Content-Type'), 'application/json') === 0) {
			$data = Json::decode($request->getContent(), true);
			$request->request->replace(is_array($data) ? $data : []);
		}
	}
}