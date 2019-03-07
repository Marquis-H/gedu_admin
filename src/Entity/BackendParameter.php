<?php

namespace Admin\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="Admin\Repository\BackendParameterRepository")
 */
class BackendParameter
{
    /**
	 * @ORM\Id()
     * @ORM\Column(type="string", length=255)
     */
    private $ck;

    /**
	 * @ORM\Id()
     * @ORM\Column(type="string", length=255)
     */
    private $identify;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $parameter;

	/**
	 * @return null|string
	 */
	public function getCk(): ?string
    {
        return $this->ck;
    }

	/**
	 * @param string $ck
	 * @return BackendParameter
	 */
	public function setCk(string $ck): self
    {
        $this->ck = $ck;

        return $this;
    }

	/**
	 * @return null|string
	 */
	public function getIdentify(): ?string
    {
        return $this->identify;
    }

	/**
	 * @param string $identify
	 * @return BackendParameter
	 */
	public function setIdentify(string $identify): self
    {
        $this->identify = $identify;

        return $this;
    }

	/**
	 * @return null|string
	 */
	public function getParameter(): ?string
    {
        return $this->parameter;
    }

	/**
	 * @param null|string $parameter
	 * @return BackendParameter
	 */
	public function setParameter(?string $parameter): self
    {
        $this->parameter = $parameter;

        return $this;
    }
}
