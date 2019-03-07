<?php
/**
 * Created by PhpStorm.
 * User: marquis
 * Date: 2019/1/30
 * Time: 5:08 PM
 */

namespace Admin\Security;

use Symfony\Bridge\Doctrine\RegistryInterface;
use Symfony\Component\Security\Core\Exception\UnsupportedUserException;
use Symfony\Component\Security\Core\Exception\UsernameNotFoundException;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\UserProviderInterface;

/**
 * Class ApiKeyUserProvider
 * @package Admin\Security
 */
class ApiKeyUserProvider implements UserProviderInterface
{
	/**
	 * @var RegistryInterface
	 */
	protected $doctrine;

	/**
	 * ApiKeyUserProvider constructor.
	 * @param RegistryInterface $doctrine
	 */
	public function __construct(RegistryInterface $doctrine)
	{
		$this->doctrine = $doctrine;
	}

	/**
	 * @param string $username
	 * @return \Admin\Entity\User|null|object|UserInterface
	 */
	public function loadUserByUsername($username)
	{
		$em = $this->doctrine->getEntityManager();
		$user = $em->getRepository('Admin:User')->findOneBy([
			'phone' => $username,
			'enable' => true
		]);

		if (null === $user) {
			throw new  UsernameNotFoundException();
		}

		return $user;
	}

	/**
	 * @param UserInterface $user
	 * @return UserInterface|void
	 */
	public function refreshUser(UserInterface $user)
	{
		throw new UnsupportedUserException();
	}

	/**
	 * @param string $class
	 * @return bool
	 */
	public function supportsClass($class)
	{
		return 'Admin\Entity\User' === $class;
	}
}