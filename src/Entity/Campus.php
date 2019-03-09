<?php

namespace Admin\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="Admin\Repository\CampusRepository")
 */
class Campus
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
	 * @ORM\Column(type="text", nullable=true)
	 */
	private $infomation;

	/**
	 * @ORM\OneToMany(targetEntity="Admin\Entity\User", mappedBy="Campus")
	 */
	private $user;

	/**
	 * @ORM\OneToMany(targetEntity="Admin\Entity\Content", mappedBy="Campus")
	 */
	private $contents;

	/**
	 * @ORM\OneToMany(targetEntity="Admin\Entity\Prize", mappedBy="Campus")
	 */
	private $prizes;

	/**
	 * Campus constructor.
	 */
	public function __construct()
	{
		$this->user = new ArrayCollection();
		$this->contents = new ArrayCollection();
		$this->prizes = new ArrayCollection();
	}

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
	 * @return Campus
	 */
	public function setTitle(string $title): self
	{
		$this->title = $title;

		return $this;
	}

	/**
	 * @return null|string
	 */
	public function getInfomation(): ?string
	{
		return $this->infomation;
	}

	/**
	 * @param null|string $infomation
	 * @return Campus
	 */
	public function setInfomation(?string $infomation): self
	{
		$this->infomation = $infomation;

		return $this;
	}

	/**
	 * @return Collection|User[]
	 */
	public function getUser(): Collection
	{
		return $this->user;
	}

	/**
	 * @param User $user
	 * @return Campus
	 */
	public function addUser(User $user): self
	{
		if (!$this->user->contains($user)) {
			$this->user[] = $user;
			$user->setCampus($this);
		}

		return $this;
	}

	/**
	 * @param User $user
	 * @return Campus
	 */
	public function removeUser(User $user): self
	{
		if ($this->user->contains($user)) {
			$this->user->removeElement($user);
			// set the owning side to null (unless already changed)
			if ($user->getCampus() === $this) {
				$user->setCampus(null);
			}
		}

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
			$content->setCampus($this);
		}

		return $this;
	}

	public function removeContent(Content $content): self
	{
		if ($this->contents->contains($content)) {
			$this->contents->removeElement($content);
			// set the owning side to null (unless already changed)
			if ($content->getCampus() === $this) {
				$content->setCampus(null);
			}
		}

		return $this;
	}

	/**
	 * @return Collection|Prize[]
	 */
	public function getPrizes(): Collection
	{
		return $this->prizes;
	}

	public function addPrize(Prize $prize): self
	{
		if (!$this->prizes->contains($prize)) {
			$this->prizes[] = $prize;
			$prize->setCampus($this);
		}

		return $this;
	}

	public function removePrize(Prize $prize): self
	{
		if ($this->prizes->contains($prize)) {
			$this->prizes->removeElement($prize);
			// set the owning side to null (unless already changed)
			if ($prize->getCampus() === $this) {
				$prize->setCampus(null);
			}
		}

		return $this;
	}
}
