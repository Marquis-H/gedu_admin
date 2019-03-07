<?php

namespace Admin\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * @ORM\Entity(repositoryClass="Admin\Repository\ContentRepository")
 */
class Content
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
	 * @ORM\Column(type="text", nullable=true)
	 */
	private $summary;

	/**
	 * @ORM\Column(type="text")
	 */
	private $content;

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
	 * @ORM\ManyToOne(targetEntity="Admin\Entity\ContentCat", inversedBy="contents")
	 * @ORM\JoinColumn(nullable=false)
	 */
	private $ContentCat;

	/**
	 * @ORM\Column(type="text", nullable=true)
	 */
	private $extra;

	/**
	 * @ORM\ManyToOne(targetEntity="Admin\Entity\Campus", inversedBy="contents")
	 */
	private $Campus;

	public function getId(): ?int
	{
		return $this->id;
	}

	public function getTitle(): ?string
	{
		return $this->title;
	}

	public function setTitle(string $title): self
	{
		$this->title = $title;

		return $this;
	}

	public function getPhoto(): ?string
	{
		return $this->photo;
	}

	public function setPhoto(?string $photo): self
	{
		$this->photo = $photo;

		return $this;
	}

	public function getSummary(): ?string
	{
		return $this->summary;
	}

	public function setSummary(?string $summary): self
	{
		$this->summary = $summary;

		return $this;
	}

	public function getContent(): ?string
	{
		return $this->content;
	}

	public function setContent(string $content): self
	{
		$this->content = $content;

		return $this;
	}

	public function getDisabled(): ?bool
	{
		return $this->disabled;
	}

	public function setDisabled(bool $disabled): self
	{
		$this->disabled = $disabled;

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

	public function getUpdatedAt(): ?\DateTimeInterface
	{
		return $this->updatedAt;
	}

	public function setUpdatedAt(\DateTimeInterface $updatedAt): self
	{
		$this->updatedAt = $updatedAt;

		return $this;
	}

	public function getContentCat(): ?ContentCat
	{
		return $this->ContentCat;
	}

	public function setContentCat(?ContentCat $ContentCat): self
	{
		$this->ContentCat = $ContentCat;

		return $this;
	}

	public function getExtra(): ?string
	{
		return $this->extra;
	}

	public function setExtra(?string $extra): self
	{
		$this->extra = $extra;

		return $this;
	}

	public function getCampus(): ?Campus
	{
		return $this->Campus;
	}

	public function setCampus(?Campus $Campus): self
	{
		$this->Campus = $Campus;

		return $this;
	}
}
