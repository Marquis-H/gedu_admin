<?php
/**
 * Created by PhpStorm.
 * User: marquis
 * Date: 2018/11/4
 * Time: 9:42 PM
 */

namespace Admin\EventListener;

use Symfony\Component\HttpKernel\Event\GetResponseEvent;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Class DoctrineExtensionListener
 * @package Admin\EventListener
 */
class DoctrineExtensionListener implements ContainerAwareInterface
{
	/**
	 * @var ContainerInterface
	 */
	protected $container;

	/**
	 * @param ContainerInterface|null $container
	 */
	public function setContainer(ContainerInterface $container = null)
	{
		$this->container = $container;
	}

	/**
	 * @param GetResponseEvent $event
	 */
	public function onLateKernelRequest(GetResponseEvent $event)
	{
		$translatable = $this->container->get('gedmo.listener.translatable');
		$translatable->setTranslatableLocale($event->getRequest()->getLocale());
	}

	/**
	 * @param GetResponseEvent $event
	 */
	public function onKernelRequest(GetResponseEvent $event)
	{
		$securityContext = $this->container->get('security.context_listener', ContainerInterface::NULL_ON_INVALID_REFERENCE);
		if (null !== $securityContext && null !== $securityContext->getToken() && $securityContext->isGranted('IS_AUTHENTICATED_REMEMBERED')) {
			$loggable = $this->container->get('gedmo.listener.loggable');
			$loggable->setUsername($securityContext->getToken()->getUsername());
		}
	}
}