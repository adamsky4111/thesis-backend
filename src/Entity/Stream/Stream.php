<?php

namespace App\Entity\Stream;

use App\Entity\Base\AbstractEntity;
use App\Entity\User\Settings;
use App\Repository\Stream\StreamRepositoryInterface;
use DateTimeInterface;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=StreamRepository::class)
 */
class Stream extends AbstractEntity
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
     * @ORM\Column(name="starting_at", type="datetime")
     */
    protected DateTimeInterface $startingAt;

    /**
     * @ORM\Column(name="ending_at", type="datetime", nullable=true)
     */
    protected ?DateTimeInterface $endingAt;

    /**
     * @ORM\Column(name="description", type="text", nullable=true)
     */
    protected string $description;

    /**
     * @Orm\OneToOne(targetEntity=Chat::class)
     * @Orm\JoinColumn(name="chat_id", referencedColumnName="id")
     */
    protected Chat $chat;

    /**
     * @ORM\OneToMany(targetEntity=StreamViewer::class, mappedBy="stream")
     */
    private iterable $viewers;

    /**
     * @ORM\ManyToOne(targetEntity=Channel::class, inversedBy="streams")
     */
    protected Channel $channel;

    public function __construct(
        Settings $settings,
    ) {
        $this->settings = $settings;
        $this->chat = new Chat();
        $this->viewers = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getSettings(): Settings
    {
        return $this->settings;
    }

    public function setSettings(Settings $settings): self
    {
        $this->settings = $settings;

        return $this;
    }

    public function getStartingAt(): ?DateTimeInterface
    {
        return $this->startingAt;
    }

    public function setStartingAt(DateTimeInterface $startingAt): self
    {
        $this->startingAt = $startingAt;

        return $this;
    }

    public function getEndingAt(): ?DateTimeInterface
    {
        return $this->endingAt;
    }

    public function setEndingAt(DateTimeInterface $endingAt): self
    {
        $this->endingAt = $endingAt;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }

    /**
     * @return Chat
     */
    public function getChat(): Chat
    {
        return $this->chat;
    }

    /**
     * @param Chat $chat
     */
    public function setChat(Chat $chat): void
    {
        $this->chat = $chat;
    }

    /**
     * @return Channel
     */
    public function getChannel(): Channel
    {
        return $this->channel;
    }

    /**
     * @param Channel $channel
     */
    public function setChannel(Channel $channel): void
    {
        $this->channel = $channel;
    }

    /**
     * @return Collection|StreamViewer[]
     */
    public function getViewers(): Collection
    {
        return $this->viewers;
    }

    public function addViewer(StreamViewer $viewer): self
    {
        if (!$this->viewers->contains($viewer)) {
            $this->viewers[] = $viewer;
            $viewer->setStream($this);
        }

        return $this;
    }

    public function removeViewer(StreamViewer $viewer): self
    {
        if ($this->viewers->removeElement($viewer)) {
            // set the owning side to null (unless already changed)
            if ($viewer->getStream() === $this) {
                $viewer->setStream(null);
            }
        }

        return $this;
    }
}
