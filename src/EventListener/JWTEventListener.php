<?php
/**
 * Created by PhpStorm.
 * User: Marquis
 * Date: 2018/9/1
 * Time: 下午3:24
 */

namespace Admin\EventListener;


use Admin\Entity\BackendUser;
use Admin\Repository\BackendUserRepository;
use Doctrine\ORM\EntityManager;
use Lexik\Bundle\JWTAuthenticationBundle\Event\AuthenticationFailureEvent;
use Lexik\Bundle\JWTAuthenticationBundle\Event\AuthenticationSuccessEvent;
use Lexik\Bundle\JWTAuthenticationBundle\Event\JWTCreatedEvent;
use Lexik\Bundle\JWTAuthenticationBundle\Event\JWTDecodedEvent;
use Lexik\Bundle\JWTAuthenticationBundle\Events;
use Lexik\Bundle\JWTAuthenticationBundle\Response\JWTAuthenticationFailureResponse;
use Symfony\Component\DependencyInjection\ContainerAwareTrait;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

/**
 * Class JWTEventListener
 * @package Admin\EventListener
 */
class JWTEventListener implements EventSubscriberInterface
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
	 * @return array
	 */
	public static function getSubscribedEvents()
	{
		return [
			Events::AUTHENTICATION_SUCCESS => 'onAuthenticationSuccessResponse',
			Events::AUTHENTICATION_FAILURE => 'onAuthenticationFailureResponse',
			Events::JWT_DECODED => 'onJWTDecoded'
		];
	}

	/**
	 * @param AuthenticationSuccessEvent $event
	 */
	public function onAuthenticationSuccessResponse(AuthenticationSuccessEvent $event)
	{
		$data = $event->getData();
		$data['roles'] = $event->getUser()->getRoles();
		$event->setData($data);
	}

	/**
	 * @param AuthenticationFailureEvent $event
	 */
	public function onAuthenticationFailureResponse(AuthenticationFailureEvent $event)
	{
		$response = new JWTAuthenticationFailureResponse('Bad credentials', 200);
		$event->setResponse($response);
	}

	/**
	 * @param JWTDecodedEvent $event
	 */
	public function onJWTDecoded(JWTDecodedEvent $event)
	{
		/** @var EntityManager $em */
		$em = $this->container->get('doctrine.orm.default_entity_manager');
		$payload = $event->getPayload();

		// roles
		$roles = $payload['roles'];
		$isApp = in_array('app', $roles);
		/** @var BackendUserRepository $backendUser */
		$backendUserRepo = $em->getRepository('Admin:BackendUser');
		$userRepo = $em->getRepository('Admin:User');
		if ($isApp) {
			$user = $userRepo->findOneBy(['phone' => $payload['username']]);
			if ($user && $user->getEnable() === false) {
				$event->markAsInvalid();
			}
		} else {
			/** @var BackendUser $backendUser */
			$backendUser = $backendUserRepo->findOneBy(['username' => $payload['username']]);
			if ($backendUser && $backendUser->getEnabled() === false) {
				$event->markAsInvalid();
			}
		}
	}
}