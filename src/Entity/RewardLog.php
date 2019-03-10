<?php

namespace Admin\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * @ORM\Entity(repositoryClass="Admin\Repository\RewardLogRepository")
 */
class RewardLog
{
	/**
	 * @ORM\Id()
	 * @ORM\GeneratedValue()
	 * @ORM\Column(type="integer")
	 */
	private $id;

	/**
	 * @ORM\Column(type="integer")
	 */
	private $integral;

	/**
	 * @ORM\Column(type="string", length=255)
	 */
	private $info;

	/**
	 * @Gedmo\Timestampable(on="create")
	 * @ORM\Column(type="datetime")
	 */
	private $createdAt;

	/**
	 * @ORM\ManyToOne(targetEntity="Admin\Entity\User", inversedBy="rewardLogs")
	 * @ORM\JoinColumn(nullable=false)
	 */
	private $User;

	public function getId(): ?int
	{
		return $this->id;
	}

	public function getIntegral(): ?int
	{
		return $this->integral;
	}

	public function setIntegral(int $integral): self
	{
		$this->integral = $integral;

		return $this;
	}

	public function getInfo(): ?string
	{
		return $this->info;
	}

	public function setInfo(string $info): self
	{
		$this->info = $info;

		return $this;
	}

	public function getCreatedAt(): ?\DateTimeInterface
	{
		return $this->createdAt;
	}

	public function setCreatedAt(\DateTimeInterface $createdAt): self
	{
		$this->createdAt = $createdAt;

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
