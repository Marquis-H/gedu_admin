<?php

namespace Admin\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="Admin\Repository\ContentCatRepository")
 */
class ContentCat
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
	 * @ORM\OneToMany(targetEntity="Admin\Entity\Content", mappedBy="ContentCat")
	 */
	private $contents;

	/**
	 * @ORM\Column(type="string", length=255, nullable=true)
	 */
	private $slug;

	public function __construct()
	{
		$this->contents = new ArrayCollection();
	}

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

	/**
	 * @return Collection|Content[]
	 */
	public function getContents(): Collection
	{
		return $this->contents;
	}

	public function addContent(Content $content): self
	{
		if (!$this->contents->contains($content)) {
			$this->contents[] = $content;
			$content->setContentCat($this);
		}

		return $this;
	}

	public function removeContent(Content $content): self
	{
		if ($this->contents->contains($content)) {
			$this->contents->removeElement($content);
			// set the owning side to null (unless already changed)
			if ($content->getContentCat() === $this) {
				$content->setContentCat(null);
			}
		}

		return $this;
	}

	public function getSlug(): ?string
	{
		return $this->slug;
	}

	public function setSlug(?string $slug): self
	{
		$this->slug = $slug;

		return $this;
	}
}
