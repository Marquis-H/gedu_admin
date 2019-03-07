<?php

namespace Admin\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="Admin\Repository\TokenRepository")
 */
class Token
{
	/**
	 * @ORM\Id()
	 * @ORM\GeneratedValue()
	 * @ORM\Column(type="integer")
	 */
	private $id;

	/**
	 * @ORM\Column(type="string", length=1024)
	 */
	private $token;

	/**
	 * @ORM\Column(type="string", length=255, nullable=true)
	 */
	private $hash;

	/**
	 * @ORM\ManyToOne(targetEntity="Admin\Entity\User", inversedBy="token")
	 */
	private $User;

	public function getId(): ?int
	{
		return $this->id;
	}

	public function getToken(): ?string
	{
		return $this->token;
	}

	public function setToken(string $token): self
	{
		$this->token = $token;

		return $this;
	}

	public function getHash(): ?string
	{
		return $this->hash;
	}

	public function setHash(?string $hash): self
	{
		$this->hash = $hash;

		return $this;
	}

	public function getUser(): ?User
	{
		return $this->User;
	}

	public function setUser(?User $User): self
	{
		$this->User = $User;

		return $this;
	}
}
