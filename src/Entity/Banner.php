<?php

namespace Admin\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="Admin\Repository\BannerRepository")
 */
class Banner
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
	private $photo;

	/**
	 * @ORM\Column(type="datetime", nullable=true)
	 */
	private $onlineAt;

	/**
	 * @ORM\Column(type="datetime", nullable=true)
	 */
	private $offlineAt;

	/**
	 * @ORM\Column(type="integer", nullable=true)
	 */
	private $position;

	/**
	 * @ORM\Column(type="string", length=255, nullable=true)
	 */
	private $slug;

	/**
	 * @ORM\ManyToOne(targetEntity="Admin\Entity\Campus")
	 */
	private $Campus;

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
	public function getPhoto(): ?string
	{
		return $this->photo;
	}

	/**
	 * @param string $photo
	 * @return Banner
	 */
	public function setPhoto(string $photo): self
	{
		$this->photo = $photo;

		return $this;
	}

	/**
	 * @return \DateTimeInterface|null
	 */
	public function getOnlineAt(): ?\DateTimeInterface
	{
		return $this->onlineAt;
	}

	/**
	 * @param \DateTimeInterface|null $onlineAt
	 * @return Banner
	 */
	public function setOnlineAt(?\DateTimeInterface $onlineAt): self
	{
		$this->onlineAt = $onlineAt;

		return $this;
	}

	/**
	 * @return \DateTimeInterface|null
	 */
	public function getOfflineAt(): ?\DateTimeInterface
	{
		return $this->offlineAt;
	}

	/**
	 * @param \DateTimeInterface|null $offlineAt
	 * @return Banner
	 */
	public function setOfflineAt(?\DateTimeInterface $offlineAt): self
	{
		$this->offlineAt = $offlineAt;

		return $this;
	}

	/**
	 * @return int|null
	 */
	public function getPosition(): ?int
	{
		return $this->position;
	}

	/**
	 * @param int|null $position
	 * @return Banner
	 */
	public function setPosition(?int $position): self
	{
		$this->position = $position;

		return $this;
	}

	/**
	 * @return null|string
	 */
	public function getSlug(): ?string
	{
		return $this->slug;
	}

	/**
	 * @param null|string $slug
	 * @return Banner
	 */
	public function setSlug(?string $slug): self
	{
		$this->slug = $slug;

		return $this;
	}

	/**
	 * @return Campus|null
	 */
	public function getCampus(): ?Campus
	{
		return $this->Campus;
	}

	/**
	 * @param Campus|null $Campus
	 * @return Banner
	 */
	public function setCampus(?Campus $Campus): self
	{
		$this->Campus = $Campus;

		return $this;
	}
}
