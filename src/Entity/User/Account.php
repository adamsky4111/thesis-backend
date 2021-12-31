<?php

namespace App\Entity\User;

use App\Entity\Base\AbstractEntity;
use App\Entity\Stream\Channel;
use App\Enum\AccountRoleEnum;
use App\Repository\User\Doctrine\AccountRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use App\Entity\Stream\Stream;
use JetBrains\PhpStorm\Pure;

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
     * @ORM\OneToOne(targetEntity=Media::class, cascade={"persist", "remove"})
     */
    protected ?Media $avatar = null;

    /**
     * @ORM\OneToOne(targetEntity=Stream::class, cascade={"persist", "remove"})
     */
    protected ?Stream $actualStream;

    /**
     * @ORM\OneToMany(targetEntity=Settings::class, mappedBy="account", cascade={"persist"})
     */
    private iterable $settings;

    /**
     * @ORM\Column(type="json")
     */
    protected iterable $roles = [];

    /**
     * @ORM\OneToMany(targetEntity=Channel::class, mappedBy="account")
     */
    private iterable $channels;

    /**
     * @ORM\OneToMany(targetEntity=AccountChannelSubscribe::class, mappedBy="account")
     */
    private iterable $subscribes;

    public function __construct(User $user)
    {
        $this->user = $user;
        $user->setAccount($this);
        $this->setAccountInformation(new AccountInformation());
        $this->setRoles([AccountRoleEnum::REGULAR_ACCOUNT]);
        $this->settings = new ArrayCollection();
        $this->channels = new ArrayCollection();
        $this->subscribes = new ArrayCollection();
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
     * @return array
     */
    public function getRoles(): array
    {
        return $this->roles;
    }

    /**
     * @param array $roles
     * @return Account
     */
    public function setRoles(array $roles): self
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * @return Media|null
     */
    public function getAvatar(): ?Media
    {
        return $this->avatar;
    }

    /**
     * @param Media|null $avatar
     */
    public function setAvatar(?Media $avatar): void
    {
        $this->avatar = $avatar;
    }

    /**
     * @return Stream|null
     */
    public function getActualStream(): ?Stream
    {
        return $this->actualStream;
    }

    /**
     * @param Stream|null $actualStream
     */
    public function setActualStream(?Stream $actualStream): void
    {
        $this->actualStream = $actualStream;
    }

    /**
     * @return Collection<Settings>
     */
    public function getSettings(): Collection
    {
        return $this->settings;
    }

    public function addSettings(Settings $settings): self
    {
        if (!$this->settings->contains($settings)) {
            $this->settings[] = $settings;
            $settings->setAccount($this);
        }

        return $this;
    }

    public function removeSettings(Settings $settings): self
    {
        if ($this->settings->contains($settings)) {
            $this->settings->removeElement($settings);
            $settings->setAccount(null);
        }

        return $this;
    }

    /**
     * @return Collection<AccountChannelSubscribe>
     */
    public function getSubscribes(): iterable
    {
        return $this->subscribes;
    }

    public function addSubscribe(AccountChannelSubscribe $subscribe): self
    {
        if (!$this->subscribes->contains($subscribe)) {
            $this->subscribes[] = $subscribe;
            $subscribe->setAccount($this);
        }

        return $this;
    }

    public function removeSubscribe(AccountChannelSubscribe $subscribe): self
    {
        if ($this->subscribes->contains($subscribe)) {
            $this->subscribes->removeElement($subscribe);
            $subscribe->setAccount(null);
        }

        return $this;
    }

    public function isChannelSubscribed(Channel $channel): bool
    {
        return (bool) $this->getSubscribeByChannel($channel);
    }

    public function getSubscribeByChannel(Channel $channel): ?AccountChannelSubscribe
    {
        foreach ($this->getSubscribes() as $subscribe) {
            if ($channel === $subscribe->getChannel()) {
                return $subscribe;
            }
        }

        return null;
    }

    public function clearSubscribers(): self
    {
        $this->subscribes = new ArrayCollection();

        return $this;
    }

    public function getDefaultSettings(): Settings|null
    {
        /** @var Settings $setting */
        foreach ($this->getSettings() as $setting) {
            if ($setting->getIsDefault()) {
                return $setting;
            }
        }

        return null;
    }

    /**
     * @return Collection|Channel[]
     */
    public function getChannels(): Collection
    {
        return $this->channels;
    }

    public function addChannel(Channel $channel): self
    {
        if (!$this->channels->contains($channel)) {
            $this->channels[] = $channel;
            $channel->setAccount($this);
        }

        return $this;
    }

    public function removeChannel(Channel $channel): self
    {
        if ($this->channels->removeElement($channel)) {
            // set the owning side to null (unless already changed)
            if ($channel->getAccount() === $this) {
                $channel->setAccount(null);
            }
        }

        return $this;
    }

    #[Pure] public function getDefaultChannel(): ?Channel
    {
        /** @var Channel $channel */
        foreach ($this->channels as $channel) {
            if ($channel->isDefault()) {
                return $channel;
            }
        }

        return null;
    }

}
