<?php

namespace Admin\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * @ORM\Entity(repositoryClass="Admin\Repository\WordUserRepository")
 */
class WordUser
{
	/**
	 * @ORM\Id()
	 * @ORM\GeneratedValue()
	 * @ORM\Column(type="integer")
	 */
	private $id;

	/**
	 * 新单词
	 *
	 * @ORM\Column(type="json_array")
	 */
	private $newWord;

	/**
	 * 今日单词
	 *
	 * @ORM\Column(type="json_array")
	 */
	private $nowWord;

	/**
	 * 剩余单词
	 *
	 * @ORM\Column(type="json_array")
	 */
	private $surplusWord;

	/**
	 * 我的单词
	 *
	 * @ORM\Column(type="json_array")
	 */
	private $meWord;

	/**
	 * @ORM\Column(type="string", length=255)
	 */
	private $type;

	/**
	 * @ORM\ManyToOne(targetEntity="Admin\Entity\User", inversedBy="wordUsers")
	 * @ORM\JoinColumn(nullable=false)
	 */
	private $User;

	/**
	 * @ORM\Column(type="boolean")
	 */
	private $isSelect = 0;

	/**
	 * 所有单词
	 *
	 * @ORM\Column(type="json_array")
	 */
	private $allWord;

	/**
	 * @ORM\OneToMany(targetEntity="Admin\Entity\WordUserLog", mappedBy="WordUser", orphanRemoval=true)
	 */
	private $wordUserLogs;

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

	public function __construct()
	{
		$this->wordUserLogs = new ArrayCollection();
	}

	public function getId(): ?int
	{
		return $this->id;
	}

	public function getNewWord()
	{
		return $this->newWord;
	}

	public function setNewWord($newWord): self
	{
		$this->newWord = $newWord;

		return $this;
	}

	public function getNowWord()
	{
		return $this->nowWord;
	}

	public function setNowWord($nowWord): self
	{
		$this->nowWord = $nowWord;

		return $this;
	}

	public function getSurplusWord()
	{
		return $this->surplusWord;
	}

	public function setSurplusWord($surplusWord): self
	{
		$this->surplusWord = $surplusWord;

		return $this;
	}

	public function getMeWord()
	{
		return $this->meWord;
	}

	public function setMeWord($meWord): self
	{
		$this->meWord = $meWord;

		return $this;
	}

	public function getType(): ?string
	{
		return $this->type;
	}

	public function setType(string $type): self
	{
		$this->type = $type;

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

	public function getIsSelect(): ?bool
	{
		return $this->isSelect;
	}

	public function setIsSelect(bool $isSelect): self
	{
		$this->isSelect = $isSelect;

		return $this;
	}

	public function getAllWord()
	{
		return $this->allWord;
	}

	public function setAllWord($allWord): self
	{
		$this->allWord = $allWord;

		return $this;
	}

	/**
	 * @return Collection|WordUserLog[]
	 */
	public function getWordUserLogs(): Collection
	{
		return $this->wordUserLogs;
	}

	public function addWordUserLog(WordUserLog $wordUserLog): self
	{
		if (!$this->wordUserLogs->contains($wordUserLog)) {
			$this->wordUserLogs[] = $wordUserLog;
			$wordUserLog->setWordUser($this);
		}

		return $this;
	}

	public function removeWordUserLog(WordUserLog $wordUserLog): self
	{
		if ($this->wordUserLogs->contains($wordUserLog)) {
			$this->wordUserLogs->removeElement($wordUserLog);
			// set the owning side to null (unless already changed)
			if ($wordUserLog->getWordUser() === $this) {
				$wordUserLog->setWordUser(null);
			}
		}

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
}
