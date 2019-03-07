<?php

namespace Admin\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * @ORM\Entity(repositoryClass="Admin\Repository\WechatBindingRepository")
 */
class WechatBinding
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
	private $openid;

	/**
	 * @Gedmo\Timestampable(on="create")
	 * @ORM\Column(type="datetime")
	 */
	private $createdAt;

	/**
	 * @ORM\OneToOne(targetEntity="Admin\Entity\User", inversedBy="wechatBinding", cascade={"persist", "remove"})
	 */
	private $User;

	/**
	 * @return int|null
	 */
	public function getId(): ?int
	{
		return $this->id;
	}

	/**
	 * @return null|string
	 */
	public function getOpenid(): ?string
	{
		return $this->openid;
	}

	/**
	 * @param string $openid
	 * @return WechatBinding
	 */
	public function setOpenid(string $openid): self
	{
		$this->openid = $openid;

		return $this;
	}

	/**
	 * @return \DateTimeInterface|null
	 */
	public function getCreatedAt(): ?\DateTimeInterface
	{
		return $this->createdAt;
	}

	/**
	 * @param \DateTimeInterface $createdAt
	 * @return WechatBinding
	 */
	public function setCreatedAt(\DateTimeInterface $createdAt): self
	{
		$this->createdAt = $createdAt;

		return $this;
	}

	/**
	 * @return User|null
	 */
	public function getUser(): ?User
	{
		return $this->User;
	}

	/**
	 * @param User|null $User
	 * @return WechatBinding
	 */
	public function setUser(?User $User): self
	{
		$this->User = $User;

		return $this;
	}
}
