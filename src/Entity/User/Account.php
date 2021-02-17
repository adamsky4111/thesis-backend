<?php

namespace App\Entity\User;

use App\Entity\Base\AbstractEntity;
use App\Enum\AccountRoleEnum;
use App\Repository\User\AccountRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=AccountRepository::class)
 */
class Account extends AbstractEntity
{
    /**
     * @ORM\OneToOne(targetEntity=User::class, inversedBy="account", cascade={"persist", "remove"})
     * @ORM\JoinColumn(nullable=false)
     */
    protected User $user;

    /**
     * @ORM\OneToOne(targetEntity=AccountInformation::class, inversedBy="account", cascade={"persist", "remove"})
     */
    protected ?AccountInformation $accountInformation;

    /**
     * @ORM\ManyToMany(targetEntity="Settings")
     * @ORM\JoinTable(name="account_settings",
     *      joinColumns={@ORM\JoinColumn(name="account_id", referencedColumnName="id")},
     *      inverseJoinColumns={@ORM\JoinColumn(name="setting_id", referencedColumnName="id")}
     *      )
     */
    protected iterable $settings;

    /**
     * @ORM\Column(type="json")
     */
    protected iterable $roles = [];

    public function __construct(User $user)
    {
        $this->setUser($user);
        $user->setAccount($this);
        $this->setAccountInformation(new AccountInformation());
        $this->setRoles([AccountRoleEnum::REGULAR_ACCOUNT]);
        $this->settings = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(User $user): self
    {
        if ($user->getAccount() !== $this) {
            $user->setAccount($this);
        }

        return $this;
    }

    public function getAccountInformation(): ?AccountInformation
    {
        return $this->accountInformation;
    }

    public function setAccountInformation(?AccountInformation $accountInformation): self
    {
        $this->accountInformation = $accountInformation;

        return $this;
    }

    /**
     * @return iterable
     */
    public function getRoles(): iterable
    {
        return $this->roles;
    }

    /**
     * @param iterable $roles
     * @return Account
     */
    public function setRoles(iterable $roles): self
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * @return Collection|Settings[]
     */
    public function getSettings(): Collection
    {
        return $this->settings;
    }

    public function addSettings(Settings $settings): self
    {
        if (!$this->settings->contains($settings)) {
            $this->settings[] = $settings;
        }

        return $this;
    }

    public function removeSettings(Settings $settings): self
    {
        if ($this->settings->contains($settings)) {
            $this->settings->removeElement($settings);
        }

        return $this;
    }

    public function clearSettings(): self
    {
        $this->settings = new ArrayCollection();

        return $this;
    }

}
