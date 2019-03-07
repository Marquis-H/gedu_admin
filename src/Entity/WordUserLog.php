<?php

namespace Admin\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * @ORM\Entity(repositoryClass="Admin\Repository\WordUserLogRepository")
 */
class WordUserLog
{
	/**
	 * @ORM\Id()
	 * @ORM\GeneratedValue()
	 * @ORM\Column(type="integer")
	 */
	private $id;

	/**
	 * 当天完成的
	 *
	 * @ORM\Column(type="json_array")
	 */
	private $knownWord;

	/**
	 * @ORM\Column(type="boolean")
	 */
	private $isComplete;

	/**
	 * @ORM\ManyToOne(targetEntity="Admin\Entity\WordUser", inversedBy="wordUserLogs")
	 * @ORM\JoinColumn(nullable=false)
	 */
	private $WordUser;

	/**
	 * @Gedmo\Timestampable(on="create")
	 * @ORM\Column(type="datetime")
	 */
	private $createdAt;

	public function getId(): ?int
	{
		return $this->id;
	}

	public function getKnownWord()
	{
		return $this->knownWord;
	}

	public function setKnownWord($knownWord): self
	{
		$this->knownWord = $knownWord;

		return $this;
	}

	public function getIsComplete(): ?bool
	{
		return $this->isComplete;
	}

	public function setIsComplete(bool $isComplete): self
	{
		$this->isComplete = $isComplete;

		return $this;
	}

	public function getWordUser(): ?WordUser
	{
		return $this->WordUser;
	}

	public function setWordUser(?WordUser $WordUser): self
	{
		$this->WordUser = $WordUser;

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
}
