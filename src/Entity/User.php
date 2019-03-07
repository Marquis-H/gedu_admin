<?php

namespace Admin\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * @ORM\Entity(repositoryClass="Admin\Repository\UserRepository")
 */
class User implements UserInterface
{
	/**
	 * @ORM\Id()
	 * @ORM\GeneratedValue()
	 * @ORM\Column(type="integer")
	 */
	private $id;

	/**
	 * @ORM\Column(type="string", length=255, nullable=true)
	 */
	private $avatar;

	/**
	 * @ORM\Column(type="string", length=255, nullable=true)
	 */
	private $nickname;

	/**
	 * @ORM\Column(type="string", length=255, nullable=true)
	 */
	private $name;

	/**
	 * @ORM\Column(type="string", length=255, nullable=true)
	 */
	private $gender;

	/**
	 * @ORM\Column(type="datetime", nullable=true)
	 */
	private $birthday;

	/**
	 * @ORM\Column(type="string", length=255)
	 */
	private $phone;

	/**
	 * @ORM\Column(type="boolean")
	 */
	private $enable;

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
	 * @ORM\OneToOne(targetEntity="Admin\Entity\WechatBinding", mappedBy="User", cascade={"persist", "remove"})
	 */
	private $wechatBinding;

	/**
	 * @ORM\ManyToOne(targetEntity="Admin\Entity\Campus", inversedBy="user")
	 */
	private $Campus;

	/**
	 * @ORM\OneToMany(targetEntity="Admin\Entity\Token", mappedBy="User")
	 */
	private $token;

	/**
	 * @ORM\Column(type="boolean")
	 */
	private $isMember = 0;

	/**
	 * @ORM\Column(type="string", length=255, nullable=true)
	 */
	private $invitationCode;

	/**
	 * 积分
	 *
	 * @ORM\Column(type="integer")
	 */
	private $integral = 0;

	/**
	 * @ORM\OneToMany(targetEntity="Admin\Entity\RewardLog", mappedBy="User")
	 */
	private $rewardLogs;

	/**
	 * @ORM\OneToMany(targetEntity="Admin\Entity\WordUser", mappedBy="User")
	 */
	private $wordUsers;

	/**
	 * @return array
	 */
	public function getRoles()
	{
		return ['app'];
	}


	public function __construct()
	{
		$this->token = new ArrayCollection();
		$this->rewardLogs = new ArrayCollection();
		$this->wordUsers = new ArrayCollection();
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
	public function getNickname(): ?string
	{
		return $this->nickname;
	}

	/**
	 * @param null|string $nickname
	 * @return User
	 */
	public function setNickname(?string $nickname): self
	{
		$this->nickname = $nickname;

		return $this;
	}

	/**
	 * @return null|string
	 */
	public function getName(): ?string
	{
		return $this->name;
	}

	/**
	 * @param null|string $name
	 * @return User
	 */
	public function setName(?string $name): self
	{
		$this->name = $name;

		return $this;
	}

	/**
	 * @return null|string
	 */
	public function getGender(): ?string
	{
		return $this->gender;
	}

	/**
	 * @param null|string $gender
	 * @return User
	 */
	public function setGender(?string $gender): self
	{
		$this->gender = $gender;

		return $this;
	}

	/**
	 * @return \DateTimeInterface|null
	 */
	public function getBirthday(): ?\DateTimeInterface
	{
		return $this->birthday;
	}

	/**
	 * @param \DateTimeInterface|null $birthday
	 * @return User
	 */
	public function setBirthday(?\DateTimeInterface $birthday): self
	{
		$this->birthday = $birthday;

		return $this;
	}

	/**
	 * @return null|string
	 */
	public function getPhone(): ?string
	{
		return $this->phone;
	}

	/**
	 * @param string $phone
	 * @return User
	 */
	public function setPhone(string $phone): self
	{
		$this->phone = $phone;

		return $this;
	}

	/**
	 * @return null|string
	 */
	public function getAvatar(): ?string
	{
		return $this->avatar;
	}

	/**
	 * @param null|string $avatar
	 * @return User
	 */
	public function setAvatar(?string $avatar): self
	{
		$this->avatar = $avatar;

		return $this;
	}

	/**
	 * @return bool|null
	 */
	public function getEnable(): ?bool
	{
		return $this->enable;
	}

	/**
	 * @param bool $enable
	 * @return User
	 */
	public function setEnable(bool $enable): self
	{
		$this->enable = $enable;

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
	 * @return User
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
	 * @return User
	 */
	public function setUpdatedAt(\DateTimeInterface $updatedAt): self
	{
		$this->updatedAt = $updatedAt;

		return $this;
	}

	/**
	 * @return WechatBinding|null
	 */
	public function getWechatBinding(): ?WechatBinding
	{
		return $this->wechatBinding;
	}

	/**
	 * @param WechatBinding|null $wechatBinding
	 * @return User
	 */
	public function setWechatBinding(?WechatBinding $wechatBinding): self
	{
		$this->wechatBinding = $wechatBinding;

		// set (or unset) the owning side of the relation if necessary
		$newUser = $wechatBinding === null ? null : $this;
		if ($newUser !== $wechatBinding->getUser()) {
			$wechatBinding->setUser($newUser);
		}

		return $this;
	}

	/**
	 * @return Campus|null
	 */
	public function getCampus(): ?Campus
	{
		return $this->Campus;
	}

	/**
	 * @param Campus|null $Campus
	 * @return User
	 */
	public function setCampus(?Campus $Campus): self
	{
		$this->Campus = $Campus;

		return $this;
	}

	/**
	 * @return Collection|Token[]
	 */
	public function getToken(): Collection
	{
		return $this->token;
	}

	public function addToken(Token $token): self
	{
		if (!$this->token->contains($token)) {
			$this->token[] = $token;
			$token->setUser($this);
		}

		return $this;
	}

	public function removeToken(Token $token): self
	{
		if ($this->token->contains($token)) {
			$this->token->removeElement($token);
			// set the owning side to null (unless already changed)
			if ($token->getUser() === $this) {
				$token->setUser(null);
			}
		}

		return $this;
	}

	public function getPassword()
	{
		// TODO: Implement getSalt() method.
	}

	public function getSalt()
	{
		// TODO: Implement getSalt() method.
	}

	public function getUsername()
	{
		// TODO: Implement getUsername() method.
	}

	public function eraseCredentials()
	{
		// TODO: Implement eraseCredentials() method.
	}

	public function getIsMember(): ?bool
	{
		return $this->isMember;
	}

	public function setIsMember(bool $isMember): self
	{
		$this->isMember = $isMember;

		return $this;
	}

	public function getInvitationCode(): ?string
	{
		return $this->invitationCode;
	}

	public function setInvitationCode(?string $invitationCode): self
	{
		$this->invitationCode = $invitationCode;

		return $this;
	}

	public function getIntegral(): ?int
	{
		return $this->integral;
	}

	public function setIntegral(int $integral): self
	{
		$this->integral = $integral;

		return $this;
	}

	/**
	 * @return Collection|RewardLog[]
	 */
	public function getRewardLogs(): Collection
	{
		return $this->rewardLogs;
	}

	public function addRewardLog(RewardLog $rewardLog): self
	{
		if (!$this->rewardLogs->contains($rewardLog)) {
			$this->rewardLogs[] = $rewardLog;
			$rewardLog->setUser($this);
		}

		return $this;
	}

	public function removeRewardLog(RewardLog $rewardLog): self
	{
		if ($this->rewardLogs->contains($rewardLog)) {
			$this->rewardLogs->removeElement($rewardLog);
			// set the owning side to null (unless already changed)
			if ($rewardLog->getUser() === $this) {
				$rewardLog->setUser(null);
			}
		}

		return $this;
	}

	/**
	 * @return Collection|WordUser[]
	 */
	public function getWordUsers(): Collection
	{
		return $this->wordUsers;
	}

	public function addWordUser(WordUser $wordUser): self
	{
		if (!$this->wordUsers->contains($wordUser)) {
			$this->wordUsers[] = $wordUser;
			$wordUser->setUser($this);
		}

		return $this;
	}

	public function removeWordUser(WordUser $wordUser): self
	{
		if ($this->wordUsers->contains($wordUser)) {
			$this->wordUsers->removeElement($wordUser);
			// set the owning side to null (unless already changed)
			if ($wordUser->getUser() === $this) {
				$wordUser->setUser(null);
			}
		}

		return $this;
	}
}
