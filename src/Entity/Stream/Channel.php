<?php

namespace App\Entity\Stream;

use App\Entity\Base\AbstractEntity;
use App\Entity\User\Settings;
use App\Repository\Stream\ChannelRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ChannelRepository::class)
 */
class Channel extends AbstractEntity
{
    /**
     * @ORM\Column(name="name", type="string", length=255)
     */
    protected string $name;

    /**
     * @ORM\ManyToOne(targetEntity=Settings::class)
     */
    protected Settings $settings;

    /**
     * @ORM\Column(name="description", type="text", nullable=true)
     */
    protected string $description;

    /**
     * @ORM\OneToMany(targetEntity=ChannelFollower::class, mappedBy="stream")
     */
    private iterable $followers;

    /**
     * @ORM\OneToMany(targetEntity=Stream::class, mappedBy="channel")
     */
    private iterable $streams;

    public function __construct(
        Settings $settings,
    ) {
        $this->settings = $settings;
        $this->followers = new ArrayCollection();
        $this->streams = new ArrayCollection();
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @param string $name
     */
    public function setName(string $name): void
    {
        $this->name = $name;
    }

    /**
     * @return Settings
     */
    public function getSettings(): Settings
    {
        return $this->settings;
    }

    /**
     * @param Settings $settings
     */
    public function setSettings(Settings $settings): void
    {
        $this->settings = $settings;
    }

    /**
     * @return string
     */
    public function getDescription(): string
    {
        return $this->description;
    }

    /**
     * @param string $description
     */
    public function setDescription(string $description): void
    {
        $this->description = $description;
    }

    /**
     * @return Collection|ChannelFollower[]
     */
    public function getFollowers(): Collection
    {
        return $this->followers;
    }

    public function addFollower(ChannelFollower $follower): self
    {
        if (!$this->followers->contains($follower)) {
            $this->followers[] = $follower;
            $follower->setChannel($this);
        }

        return $this;
    }

    public function removeFollower(ChannelFollower $follower): self
    {
        if ($this->followers->removeElement($follower)) {
            // set the owning side to null (unless already changed)
            if ($follower->getChannel() === $this) {
                $follower->setChannel(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Stream[]
     */
    public function getStreams(): Collection
    {
        return $this->streams;
    }

    public function addStream(Stream $stream): self
    {
        if (!$this->streams->contains($stream)) {
            $this->streams[] = $stream;
            $stream->setChannel($this);
        }

        return $this;
    }

    public function removeMessage(Stream $stream): self
    {
        if ($this->streams->removeElement($stream)) {
            // set the owning side to null (unless already changed)
            if ($stream->getChannel() === $this) {
                $stream->setChannel(null);
            }
        }

        return $this;
    }
}
