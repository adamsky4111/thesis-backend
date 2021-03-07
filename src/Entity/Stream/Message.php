<?php

namespace App\Entity\Stream;

use App\Entity\Base\AbstractEntity;
use App\Entity\Traits\CreatedAtTrait;
use App\Entity\Traits\DeletedAtTrait;
use App\Entity\Traits\UpdatedAtTrait;
use App\Entity\User\User;
use App\Repository\Stream\MessageRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=MessageRepository::class)
 */
class Message extends AbstractEntity
{
    use DeletedAtTrait,
        CreatedAtTrait,
        UpdatedAtTrait;

    /**
     * @ORM\Column(name="content", type="text")
     */
    protected string $content;

    /**
     * @Orm\ManyToOne(targetEntity=User::class)
     * @Orm\JoinColumn(name="user_id", referencedColumnName="id")
     */
    protected User $user;

    /**
     * @ORM\ManyToOne(targetEntity=Chat::class, inversedBy="messages")
     */
    protected Chat $chat;

    public function __construct(
        User $user,
        Chat $chat,
        string $content,
    ) {
        $this->user = $user;
        $this->chat = $chat;
        $this->content = $content;
    }

    public function getContent(): ?string
    {
        return $this->content;
    }

    public function setContent(string $content): self
    {
        $this->content = $content;

        return $this;
    }

    /**
     * @return User
     */
    public function getUser(): User
    {
        return $this->user;
    }

    /**
     * @param User $user
     */
    public function setUser(User $user): void
    {
        $this->user = $user;
    }

    public function getChat(): Chat
    {
        return $this->chat;
    }

    public function setChat(Chat $chat): self
    {
        $this->chat = $chat;

        return $this;
    }
}
