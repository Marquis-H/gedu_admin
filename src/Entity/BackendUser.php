<?php

namespace Admin\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * @ORM\Entity(repositoryClass="Admin\Repository\BackendUserRepository")
 */
class BackendUser implements UserInterface
{
	/**
	 * @ORM\Id()
	 * @ORM\GeneratedValue()
	 * @ORM\Column(type="integer")
	 */
	private $id;

	/**
	 * @ORM\Column(type="string", length=255, nullable=true)
	 */
	private $firstname;

	/**
	 * @ORM\Column(type="string", length=255, nullable=true)
	 */
	private $lastname;

	/**
	 * @ORM\Column(type="string", length=16, nullable=true)
	 */
	private $language;

	/**
	 * @ORM\Column(type="boolean", nullable=true)
	 */
	private $isSuperAdmin;

	/**
	 * @ORM\Column(type="string", length=16, nullable=true)
	 */
	private $gender;

	/**
	 * @ORM\Column(type="array", nullable=true)
	 */
	private $dashboard;

	/**
	 * @ORM\Column(type="array", nullable=true)
	 */
	private $configs;

	/**
	 * @ORM\ManyToMany(targetEntity="Admin\Entity\BackendGroup")
	 * @ORM\JoinTable(name="backend_user_groups")
	 */
	private $BackendGroups;

	/**
	 * @ORM\Column(type="string", length=180, unique=true)
	 */
	private $username;

	/**
	 * @ORM\Column(type="string", length=180)
	 */
	private $email;

	/**
	 * @ORM\Column(type="boolean")
	 */
	private $enabled;

	/**
	 * @ORM\Column(type="string", length=180, nullable=true)
	 */
	private $salt;

	/**
	 * @ORM\Column(type="string", length=255)
	 */
	private $password;

	/**
	 * @ORM\Column(type="array")
	 */
	private $roles;

	/**
	 * BackendUser constructor.
	 */
	public function __construct()
	{
		$this->BackendGroups = new ArrayCollection();
		$this->enabled = false;
		$this->roles = [];
		$this->salt = md5(uniqid(null, true));
	}

	public function fullName()
	{
		return $this->lastname ? $this->lastname . $this->getFirstname() : '-';
	}

	public function eraseCredentials()
	{
		// TODO: Implement eraseCredentials() method.
	}

	/**
	 * @return mixed
	 */
	public function getId()
	{
		return $this->id;
	}

	/**
	 * @return null|string
	 */
	public function getFirstname(): ?string
	{
		return $this->firstname;
	}

	/**
	 * @param null|string $firstname
	 * @return BackendUser
	 */
	public function setFirstname(?string $firstname): self
	{
		$this->firstname = $firstname;

		return $this;
	}

	/**
	 * @return null|string
	 */
	public function getLastname(): ?string
	{
		return $this->lastname;
	}

	/**
	 * @param null|string $lastname
	 * @return BackendUser
	 */
	public function setLastname(?string $lastname): self
	{
		$this->lastname = $lastname;

		return $this;
	}

	/**
	 * @return null|string
	 */
	public function getLanguage(): ?string
	{
		return $this->language;
	}

	/**
	 * @param null|string $language
	 * @return BackendUser
	 */
	public function setLanguage(?string $language): self
	{
		$this->language = $language;

		return $this;
	}

	/**
	 * @return bool|null
	 */
	public function getIsSuperAdmin(): ?bool
	{
		return $this->isSuperAdmin;
	}

	/**
	 * @param bool|null $isSuperAdmin
	 * @return BackendUser
	 */
	public function setIsSuperAdmin(?bool $isSuperAdmin): self
	{
		$this->isSuperAdmin = $isSuperAdmin;

		return $this;
	}

	/**
	 * @return null|string
	 */
	public function getGender(): ?string
	{
		return $this->gender;
	}

	/**
	 * @param null|string $gender
	 * @return BackendUser
	 */
	public function setGender(?string $gender): self
	{
		$this->gender = $gender;

		return $this;
	}

	/**
	 * @return array|null
	 */
	public function getDashboard(): ?array
	{
		return $this->dashboard;
	}

	/**
	 * @param array|null $dashboard
	 * @return BackendUser
	 */
	public function setDashboard(?array $dashboard): self
	{
		$this->dashboard = $dashboard;

		return $this;
	}

	/**
	 * @return array|null
	 */
	public function getConfigs(): ?array
	{
		return $this->configs;
	}

	/**
	 * @param array|null $configs
	 * @return BackendUser
	 */
	public function setConfigs(?array $configs): self
	{
		$this->configs = $configs;

		return $this;
	}

	/**
	 * @return Collection|BackendGroup[]
	 */
	public function getBackendGroups(): Collection
	{
		return $this->BackendGroups;
	}

	/**
	 * @param BackendGroup $backendGroup
	 * @return BackendUser
	 */
	public function addBackendGroup(BackendGroup $backendGroup): self
	{
		if (!$this->BackendGroups->contains($backendGroup)) {
			$this->BackendGroups[] = $backendGroup;
		}

		return $this;
	}

	/**
	 * @param BackendGroup $backendGroup
	 * @return BackendUser
	 */
	public function removeBackendGroup(BackendGroup $backendGroup): self
	{
		if ($this->BackendGroups->contains($backendGroup)) {
			$this->BackendGroups->removeElement($backendGroup);
		}

		return $this;
	}

	/**
	 * @return null|string
	 */
	public function getUsername(): ?string
	{
		return $this->username;
	}

	/**
	 * @param string $username
	 * @return BackendUser
	 */
	public function setUsername(string $username): self
	{
		$this->username = $username;

		return $this;
	}

	/**
	 * @return null|string
	 */
	public function getEmail(): ?string
	{
		return $this->email;
	}

	/**
	 * @param string $email
	 * @return BackendUser
	 */
	public function setEmail(string $email): self
	{
		$this->email = $email;

		return $this;
	}

	/**
	 * @return bool|null
	 */
	public function getEnabled(): ?bool
	{
		return $this->enabled;
	}

	/**
	 * @param bool $enabled
	 * @return BackendUser
	 */
	public function setEnabled(bool $enabled): self
	{
		$this->enabled = $enabled;

		return $this;
	}

	/**
	 * @return null|string
	 */
	public function getSalt(): ?string
	{
		return $this->salt;
	}

	/**
	 * @param null|string $salt
	 * @return BackendUser
	 */
	public function setSalt(?string $salt): self
	{
		$this->salt = $salt;

		return $this;
	}

	/**
	 * @return null|string
	 */
	public function getPassword(): ?string
	{
		return $this->password;
	}

	/**
	 * @param string $password
	 * @return BackendUser
	 */
	public function setPassword(string $password): self
	{
		$this->password = $password;

		return $this;
	}

	/**
	 * @param $role
	 * @return $this
	 */
	public function addRoles($role)
	{
		if (!in_array($role, $this->roles, true)) {
			$this->roles[] = $role;
		}

		return $this;
	}

	/**
	 * @return array|null
	 */
	public function getRoles(): ?array
	{
		return $this->roles;
	}

	/**
	 * @param array $roles
	 * @return BackendUser
	 */
	public function setRoles(array $roles): self
	{
		$this->roles = $roles;

		return $this;
	}
}
