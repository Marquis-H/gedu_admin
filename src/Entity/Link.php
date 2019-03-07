<?php

namespace Admin\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Gedmo\Translatable\Translatable;

/**
 * @ORM\Table(name="backend_link")
 * @ORM\Entity(repositoryClass="Admin\Repository\LinkRepository")
 */
class Link extends Posts implements Translatable
{
	/**
	 * @ORM\Column(type="string", length=255, nullable=true)
	 */
	private $url;

	/**
	 * @ORM\Column(type="array", nullable=true)
	 */
	private $extra;

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
	 * @ORM\Column(type="boolean", nullable=true)
	 */
	private $newWindow;

	/**
	 * @Gedmo\Translatable
	 * @ORM\Column(type="string", length=255, nullable=true)
	 */
	private $otherUrl;

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
	public function getUrl(): ?string
	{
		return $this->url;
	}

	/**
	 * @param null|string $url
	 * @return Link
	 */
	public function setUrl(?string $url): self
	{
		$this->url = $url;

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
	 * @return Link
	 */
	public function setExtra(?array $extra): self
	{
		$this->extra = $extra;

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
	 * @return Link
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
	 * @return Link
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
	 * @return Link
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
	 * @return Link
	 */
	public function setUpdatedBy(string $updatedBy): self
	{
		$this->updatedBy = $updatedBy;

		return $this;
	}

	/**
	 * @return null|string
	 */
	public function getTitle(): ?string
	{
		return $this->title;
	}

	/**
	 * @param null|string $title
	 * @return Link
	 */
	public function setTitle(?string $title): self
	{
		$this->title = $title;

		return $this;
	}

	/**
	 * @return bool|null
	 */
	public function getNewWindow(): ?bool
	{
		return $this->newWindow;
	}

	/**
	 * @param bool|null $newWindow
	 * @return Link
	 */
	public function setNewWindow(?bool $newWindow): self
	{
		$this->newWindow = $newWindow;

		return $this;
	}

	/**
	 * @return null|string
	 */
	public function getOtherUrl(): ?string
	{
		return $this->otherUrl;
	}

	/**
	 * @param null|string $otherUrl
	 * @return Link
	 */
	public function setOtherUrl(?string $otherUrl): self
	{
		$this->otherUrl = $otherUrl;

		return $this;
	}
}
