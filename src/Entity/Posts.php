<?php

namespace Admin\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Table(name="backend_posts")
 * @ORM\Entity(repositoryClass="Admin\Repository\PostsRepository")
 * @ORM\InheritanceType("JOINED")
 * @ORM\DiscriminatorColumn(name="postType", type="string")
 * @ORM\DiscriminatorMap({"link" = "Link", "page" = "Page"})
 */
abstract class Posts
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

	/**
	 * @return int|null
	 */
	public function getId(): ?int
    {
        return $this->id;
    }
}
