<?php

namespace Admin\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="Admin\Repository\WordRepository")
 */
class Word
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
    private $word;

    /**
     * @ORM\Column(type="integer")
     */
    private $rate;

    /**
     * @ORM\Column(type="json_array", nullable=true)
     */
    private $translation;

    /**
     * @ORM\Column(type="json_array", nullable=true)
     */
    private $shapes;

    /**
     * @ORM\Column(type="json_array", nullable=true)
     */
    private $collins;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $isCrawled;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $isSplited;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $enMp3;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $usMp3;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $ttsMp3;

    /**
     * @ORM\Column(type="json_array", nullable=true)
     */
    private $data;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $mp3downloaded;

    /**
     * @ORM\Column(type="json_array", nullable=true)
     */
    private $exchanges;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $collinsSplited;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $enSymbol;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $usSymbol;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $annotation;

    /**
     * @ORM\Column(type="array", nullable=true)
     */
    private $tabs;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getWord(): ?string
    {
        return $this->word;
    }

    public function setWord(string $word): self
    {
        $this->word = $word;

        return $this;
    }

    public function getRate(): ?int
    {
        return $this->rate;
    }

    public function setRate(int $rate): self
    {
        $this->rate = $rate;

        return $this;
    }

    public function getTranslation()
    {
        return $this->translation;
    }

    public function setTranslation($translation): self
    {
        $this->translation = $translation;

        return $this;
    }

    public function getShapes()
    {
        return $this->shapes;
    }

    public function setShapes($shapes): self
    {
        $this->shapes = $shapes;

        return $this;
    }

    public function getCollins()
    {
        return $this->collins;
    }

    public function setCollins($collins): self
    {
        $this->collins = $collins;

        return $this;
    }

    public function getIsCrawled(): ?bool
    {
        return $this->isCrawled;
    }

    public function setIsCrawled(?bool $isCrawled): self
    {
        $this->isCrawled = $isCrawled;

        return $this;
    }

    public function getIsSplited(): ?bool
    {
        return $this->isSplited;
    }

    public function setIsSplited(?bool $isSplited): self
    {
        $this->isSplited = $isSplited;

        return $this;
    }

    public function getEnMp3(): ?string
    {
        return $this->enMp3;
    }

    public function setEnMp3(?string $enMp3): self
    {
        $this->enMp3 = $enMp3;

        return $this;
    }

    public function getUsMp3(): ?string
    {
        return $this->usMp3;
    }

    public function setUsMp3(?string $usMp3): self
    {
        $this->usMp3 = $usMp3;

        return $this;
    }

    public function getTtsMp3(): ?string
    {
        return $this->ttsMp3;
    }

    public function setTtsMp3(?string $ttsMp3): self
    {
        $this->ttsMp3 = $ttsMp3;

        return $this;
    }

    public function getData()
    {
        return $this->data;
    }

    public function setData($data): self
    {
        $this->data = $data;

        return $this;
    }

    public function getMp3downloaded(): ?bool
    {
        return $this->mp3downloaded;
    }

    public function setMp3downloaded(?bool $mp3downloaded): self
    {
        $this->mp3downloaded = $mp3downloaded;

        return $this;
    }

    public function getExchanges()
    {
        return $this->exchanges;
    }

    public function setExchanges($exchanges): self
    {
        $this->exchanges = $exchanges;

        return $this;
    }

    public function getCollinsSplited(): ?bool
    {
        return $this->collinsSplited;
    }

    public function setCollinsSplited(?bool $collinsSplited): self
    {
        $this->collinsSplited = $collinsSplited;

        return $this;
    }

    public function getEnSymbol(): ?string
    {
        return $this->enSymbol;
    }

    public function setEnSymbol(?string $enSymbol): self
    {
        $this->enSymbol = $enSymbol;

        return $this;
    }

    public function getUsSymbol(): ?string
    {
        return $this->usSymbol;
    }

    public function setUsSymbol(?string $usSymbol): self
    {
        $this->usSymbol = $usSymbol;

        return $this;
    }

    public function getAnnotation(): ?string
    {
        return $this->annotation;
    }

    public function setAnnotation(?string $annotation): self
    {
        $this->annotation = $annotation;

        return $this;
    }

    public function getTabs(): ?array
    {
        return $this->tabs;
    }

    public function setTabs(?array $tabs): self
    {
        $this->tabs = $tabs;

        return $this;
    }
}
