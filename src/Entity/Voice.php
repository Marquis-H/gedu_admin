<?php

namespace Admin\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * @ORM\Entity(repositoryClass="Admin\Repository\VoiceRepository")
 */
class Voice
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
	private $name;

	/**
	 * @ORM\Column(type="string", length=255)
	 */
	private $url;

	/**
	 * @ORM\Column(type="array", nullable=true)
	 */
	private $translation = [];

	/**
	 * @ORM\Column(type="string", length=255, nullable=true)
	 */
	private $tab = null;

	/**
	 * @Gedmo\Timestampable(on="create")
	 * @ORM\Column(type="datetime")
	 */
	private $createdAt;

	/**
	 * @ORM\ManyToOne(targetEntity="Admin\Entity\VoiceCategory", inversedBy="voices")
	 */
	private $VoiceCategory;

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
	public function getName(): ?string
	{
		return $this->name;
	}

	/**
	 * @param string $name
	 * @return Voice
	 */
	public function setName(string $name): self
	{
		$this->name = $name;

		return $this;
	}

	/**
	 * @return null|string
	 */
	public function getUrl(): ?string
	{
		return $this->url;
	}

	/**
	 * @param string $url
	 * @return Voice
	 */
	public function setUrl(string $url): self
	{
		$this->url = $url;

		return $this;
	}

	/**
	 * @return array|null
	 */
	public function getTranslation(): ?array
	{
		return $this->translation;
	}

	/**
	 * @param array|null $translation
	 * @return Voice
	 */
	public function setTranslation(?array $translation): self
	{
		$this->translation = $translation;

		return $this;
	}

	/**
	 * @return null|string
	 */
	public function getTab(): ?string
	{
		return $this->tab;
	}

	/**
	 * @param string $tab
	 * @return Voice
	 */
	public function setTab(string $tab): self
	{
		$this->tab = $tab;

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
	 * @param \DateTimeInterface $CreatedAt
	 * @return Voice
	 */
	public function setCreatedAt(\DateTimeInterface $CreatedAt): self
	{
		$this->createdAt = $CreatedAt;

		return $this;
	}

	/**
	 * @return VoiceCategory|null
	 */
	public function getVoiceCategory(): ?VoiceCategory
	{
		return $this->VoiceCategory;
	}

	/**
	 * @param VoiceCategory|null $VoiceCategory
	 * @return Voice
	 */
	public function setVoiceCategory(?VoiceCategory $VoiceCategory): self
	{
		$this->VoiceCategory = $VoiceCategory;

		return $this;
	}
}
