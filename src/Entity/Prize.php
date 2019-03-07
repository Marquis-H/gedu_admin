<?php

namespace Admin\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * @ORM\Entity(repositoryClass="Admin\Repository\PrizeRepository")
 */
class Prize
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
	private $title;

	/**
	 * @ORM\Column(type="string", length=255, nullable=true)
	 */
	private $photo;

	/**
	 * @ORM\Column(type="boolean")
	 */
	private $disabled = false;

	/**
	 * @Gedmo\Timestampable(on="create")
	 * @ORM\Column(type="datetime")
	 */
	private $createdAt;

	/**
	 * @Gedmo\Timestampable(on="update")
	 * @ORM\Column(type="datetime")
	 */
	private $updatedAt;

	/**
	 * 积分
	 *
	 * @ORM\Column(type="integer")
	 */
	private $integral;

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
	public function getTitle(): ?string
	{
		return $this->title;
	}

	/**
	 * @param string $title
	 * @return Prize
	 */
	public function setTitle(string $title): self
	{
		$this->title = $title;

		return $this;
	}

	/**
	 * @return null|string
	 */
	public function getPhoto(): ?string
	{
		return $this->photo;
	}

	/**
	 * @param null|string $photo
	 * @return Prize
	 */
	public function setPhoto(?string $photo): self
	{
		$this->photo = $photo;

		return $this;
	}

	/**
	 * @return bool|null
	 */
	public function getDisabled(): ?bool
	{
		return $this->disabled;
	}

	/**
	 * @param bool $disabled
	 * @return Prize
	 */
	public function setDisabled(bool $disabled): self
	{
		$this->disabled = $disabled;

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
	 * @return Prize
	 */
	public function setCreatedAt(\DateTimeInterface $createdAt): self
	{
		$this->createdAt = $createdAt;

		return $this;
	}

	/**
	 * @return \DateTimeInterface|null
	 */
	public function getUpdatedAt(): ?\DateTimeInterface
	{
		return $this->updatedAt;
	}

	/**
	 * @param \DateTimeInterface $updatedAt
	 * @return Prize
	 */
	public function setUpdatedAt(\DateTimeInterface $updatedAt): self
	{
		$this->updatedAt = $updatedAt;

		return $this;
	}

	/**
	 * @return int|null
	 */
	public function getIntegral(): ?int
	{
		return $this->integral;
	}

	/**
	 * @param int $integral
	 * @return Prize
	 */
	public function setIntegral(int $integral): self
	{
		$this->integral = $integral;

		return $this;
	}
}
