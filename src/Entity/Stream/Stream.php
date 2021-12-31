<?php

namespace App\Entity\Stream;

use App\Entity\Base\AbstractEntity;
use App\Entity\Base\EntityInterface;
use App\Entity\Traits\IsActiveTrait;
use App\Repository\Stream\Doctrine\StreamRepository;
use App\Entity\User\Settings;
use DateTimeInterface;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=StreamRepository::class)
 */
class Stream extends AbstractEntity implements EntityInterface
{
    use IsActiveTrait;

    /**
     * @ORM\Column(name="name", type="string", length=255)
     */
    protected string $name;

    /**
     * @ORM\Column(name="watchers_count", type="integer")
     */
    protected int $watchersCount;

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
     * @ORM\OneToOne(targetEntity=Chat::class, cascade={"persist"})
     * @ORM\JoinColumn(name="chat_id", referencedColumnName="id")
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

    /**
     * @ORM\ManyToMany(targetEntity=StreamCategory::class, fetch="LAZY")
     * @ORM\JoinTable(
     *     name="stream_categories",
     *     joinColumns={@ORM\JoinColumn(name="stream_id", referencedColumnName="id")},
     *     inverseJoinColumns={@ORM\JoinColumn(name="category_id", referencedColumnName="id")}
     * )
     */
    protected Collection $categories;

    /**
     * @ORM\ManyToMany(targetEntity=StreamTag::class, fetch="LAZY")
     * @ORM\JoinTable(
     *     name="events_tags",
     *     joinColumns={@ORM\JoinColumn(name="stream_id", referencedColumnName="id")},
     *     inverseJoinColumns={@ORM\JoinColumn(name="tag_id", referencedColumnName="id")}
     * )
     */
    protected Collection $tags;

    /**
     * @ORM\ManyToOne(targetEntity=StreamCategory::class)
     */
    protected ?StreamCategory $mainCategory = null;

    public function __construct(
        Settings $settings,
    ) {
        $this->settings = $settings;
        $this->chat = new Chat();
        $this->viewers = new ArrayCollection();
        $this->categories = new ArrayCollection();
        $this->tags = new ArrayCollection();
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

    public function getWatchersCount(): int
    {
        return $this->watchersCount;
    }

    public function setWatchersCount(int $watchersCount): void
    {
        $this->watchersCount = $watchersCount;
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

    public function getCategories(): Collection
    {
        return $this->categories;
    }

    public function addCategory(StreamCategory $category): self
    {
        if (!$this->categories->contains($category)) {
            $this->categories[] = $category;
        }

        return $this;
    }

    public function clearCategories(): self
    {
        if (!empty($this->categories)) {
            $this->categories->clear();
        }

        return $this;
    }

    public function removeCategory(StreamCategory $category): self
    {
        if ($this->categories->contains($category)) {
            $this->categories->removeElement($category);
        }

        return $this;
    }

    public function getTags(): Collection
    {
        return $this->tags;
    }

    public function addTag(StreamTag $tag): self
    {
        if (!$this->tags->contains($tag)) {
            $this->tags[] = $tag;
        }

        return $this;
    }

    public function removeTag(StreamTag $tag): self
    {
        if ($this->tags->contains($tag)) {
            $this->tags->removeElement($tag);
        }

        return $this;
    }

    public function getMainCategory(): ?StreamCategory
    {
        return $this->mainCategory;
    }

    public function setMainCategory(?StreamCategory $mainCategory): void
    {
        $this->mainCategory = $mainCategory;
    }
}
