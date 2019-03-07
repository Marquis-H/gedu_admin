<?php

namespace Admin\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="Admin\Repository\BackendRoleRepository")
 */
class BackendRole
{
	/**
	 * @ORM\Id()
	 * @ORM\GeneratedValue()
	 * @ORM\Column(type="integer")
	 */
	private $id;

	/**
	 * @ORM\Column(type="string", length=255)
	 */
	private $role;

	/**
	 * @ORM\Column(type="text", nullable=true)
	 */
	private $description;

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
	public function getRole(): ?string
	{
		return $this->role;
	}

	/**
	 * @param null|string $role
	 * @return BackendRole
	 */
	public function setRole(?string $role): self
	{
		$this->role = $role;

		return $this;
	}

	/**
	 * @return null|string
	 */
	public function getDescription(): ?string
	{
		return $this->description;
	}

	/**
	 * @param null|string $description
	 * @return BackendRole
	 */
	public function setDescription(?string $description): self
	{
		$this->description = $description;

		return $this;
	}
}
