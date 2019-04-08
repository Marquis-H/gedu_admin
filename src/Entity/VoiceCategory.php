<?php

namespace Admin\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="Admin\Repository\VoiceCategoryRepository")
 */
class VoiceCategory
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
	 * @ORM\OneToMany(targetEntity="Admin\Entity\Voice", mappedBy="VoiceCategory")
	 */
	private $voices;

	/**
	 * VoiceCategory constructor.
	 */
	public function __construct()
	{
		$this->voices = new ArrayCollection();
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
	public function getName(): ?string
	{
		return $this->name;
	}

	/**
	 * @param string $name
	 * @return VoiceCategory
	 */
	public function setName(string $name): self
	{
		$this->name = $name;

		return $this;
	}

	/**
	 * @return Collection|Voice[]
	 */
	public function getVoices(): Collection
	{
		return $this->voices;
	}

	/**
	 * @param Voice $voice
	 * @return VoiceCategory
	 */
	public function addVoice(Voice $voice): self
	{
		if (!$this->voices->contains($voice)) {
			$this->voices[] = $voice;
			$voice->setVoiceCategory($this);
		}

		return $this;
	}

	/**
	 * @param Voice $voice
	 * @return VoiceCategory
	 */
	public function removeVoice(Voice $voice): self
	{
		if ($this->voices->contains($voice)) {
			$this->voices->removeElement($voice);
			// set the owning side to null (unless already changed)
			if ($voice->getVoiceCategory() === $this) {
				$voice->setVoiceCategory(null);
			}
		}

		return $this;
	}
}
