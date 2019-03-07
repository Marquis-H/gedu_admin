<?php

namespace Admin\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Gedmo\Translatable\Translatable;

/**
 * @ORM\Table(name="backend_page")
 * @ORM\Entity(repositoryClass="Admin\Repository\PageRepository")
 */
class Page extends Posts implements Translatable
{
	/**
	 * @ORM\Column(type="string", length=255)
	 */
	private $path;

	/**
	 * @ORM\Column(type="string", length=255, nullable=true)
	 */
	private $banner;

	/**
	 * @ORM\Column(type="string", length=255, nullable=true)
	 */
	private $component;

	/**
	 * @ORM\Column(type="array", nullable=true)
	 */
	private $extra;

	/**
	 * @ORM\Column(type="datetime", nullable=true)
	 */
	private $onlineAt;

	/**
	 * @ORM\Column(type="datetime", nullable=true)
	 */
	private $offlineAt;

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
	 * @Gedmo\Blameable(on="create")
	 * @ORM\Column(type="string", length=255)
	 */
	private $createdBy;

	/**
	 * @Gedmo\Blameable(on="update")
	 * @ORM\Column(type="string", length=255)
	 */
	private $updatedBy;

	/**
	 * @Gedmo\Translatable
	 * @ORM\Column(type="string", length=255, nullable=true)
	 */
	private $title;

	/**
	 * @Gedmo\Translatable
	 * @ORM\Column(type="string", length=255, nullable=true)
	 */
	private $navTitle;

	/**
	 * @Gedmo\Translatable
	 * @ORM\Column(type="string", length=255, nullable=true)
	 */
	private $otherBanner;

	/**
	 * @Gedmo\Translatable
	 * @ORM\Column(type="text", nullable=true)
	 */
	private $summary;

	/**
	 * @Gedmo\Translatable
	 * @ORM\Column(type="text", nullable=true)
	 */
	private $content;

	/**
	 * @Gedmo\Translatable
	 * @ORM\Column(type="text", nullable=true)
	 */
	private $metaTitle;

	/**
	 * @Gedmo\Translatable
	 * @ORM\Column(type="text", nullable=true)
	 */
	private $keywords;

	/**
	 * @Gedmo\Translatable
	 * @ORM\Column(type="text", nullable=true)
	 */
	private $description;

	/**
	 * @Gedmo\Locale()
	 */
	private $locale = 'zh';

	/**
	 * @param $locale
	 */
	public function setTranslatableLocale($locale)
	{
		$this->locale = $locale;
	}

	/**
	 * @return null|string
	 */
	public function getPath(): ?string
	{
		return $this->path;
	}

	/**
	 * @param string $path
	 * @return Page
	 */
	public function setPath(string $path): self
	{
		$this->path = $path;

		return $this;
	}

	/**
	 * @return null|string
	 */
	public function getBanner(): ?string
	{
		return $this->banner;
	}

	/**
	 * @param null|string $banner
	 * @return Page
	 */
	public function setBanner(?string $banner): self
	{
		$this->banner = $banner;

		return $this;
	}

	/**
	 * @return null|string
	 */
	public function getComponent(): ?string
	{
		return $this->component;
	}

	/**
	 * @param null|string $component
	 * @return Page
	 */
	public function setComponent(?string $component): self
	{
		$this->component = $component;

		return $this;
	}

	/**
	 * @return array|null
	 */
	public function getExtra(): ?array
	{
		return $this->extra;
	}

	/**
	 * @param array|null $extra
	 * @return Page
	 */
	public function setExtra(?array $extra): self
	{
		$this->extra = $extra;

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
	 * @return Page
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
	 * @return Page
	 */
	public function setOfflineAt(?\DateTimeInterface $offlineAt): self
	{
		$this->offlineAt = $offlineAt;

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
	 * @return Page
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
	 * @return Page
	 */
	public function setUpdatedAt(\DateTimeInterface $updatedAt): self
	{
		$this->updatedAt = $updatedAt;

		return $this;
	}

	/**
	 * @return null|string
	 */
	public function getCreatedBy(): ?string
	{
		return $this->createdBy;
	}

	/**
	 * @param string $createdBy
	 * @return Page
	 */
	public function setCreatedBy(string $createdBy): self
	{
		$this->createdBy = $createdBy;

		return $this;
	}

	/**
	 * @return null|string
	 */
	public function getUpdatedBy(): ?string
	{
		return $this->updatedBy;
	}

	/**
	 * @param string $updatedBy
	 * @return Page
	 */
	public function setUpdatedBy(string $updatedBy): self
	{
		$this->updatedBy = $updatedBy;

		return $this;
	}

	public function getTitle(): ?string
	{
		return $this->title;
	}

	public function setTitle(?string $title): self
	{
		$this->title = $title;

		return $this;
	}

	public function getNavTitle(): ?string
	{
		return $this->navTitle;
	}

	public function setNavTitle(?string $navTitle): self
	{
		$this->navTitle = $navTitle;

		return $this;
	}

	public function getOtherBanner(): ?string
	{
		return $this->otherBanner;
	}

	public function setOtherBanner(?string $otherBanner): self
	{
		$this->otherBanner = $otherBanner;

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

	public function setContent(?string $content): self
	{
		$this->content = $content;

		return $this;
	}

	public function getMetaTitle(): ?string
	{
		return $this->metaTitle;
	}

	public function setMetaTitle(?string $metaTitle): self
	{
		$this->metaTitle = $metaTitle;

		return $this;
	}

	public function getKeywords(): ?string
	{
		return $this->keywords;
	}

	public function setKeywords(?string $keywords): self
	{
		$this->keywords = $keywords;

		return $this;
	}

	public function getDescription(): ?string
	{
		return $this->description;
	}

	public function setDescription(?string $description): self
	{
		$this->description = $description;

		return $this;
	}
}
