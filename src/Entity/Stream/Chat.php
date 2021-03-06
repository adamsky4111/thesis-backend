<?php

namespace App\Entity\Stream;

use App\Entity\Base\AbstractEntity;
use App\Entity\Base\EntityInterface;
use App\Repository\Stream\Doctrine\ChatRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ChatRepository::class)
 */
class Chat extends AbstractEntity implements EntityInterface
{
    /**
     * @ORM\OneToMany(targetEntity=Message::class, mappedBy="chat")
     */
    private iterable $messages;

    public function __construct()
    {
        $this->messages = new ArrayCollection();
    }

    /**
     * @return Collection
     */
    public function getMessages(): Collection
    {
        return $this->messages;
    }

    public function addMessage(Message $message): self
    {
        if (!$this->messages->contains($message)) {
            $this->messages[] = $message;
            $message->setChat($this);
        }

        return $this;
    }

    public function removeMessage(Message $message): self
    {
        if ($this->messages->removeElement($message)) {
            // set the owning side to null (unless already changed)
            if ($message->getChat() === $this) {
                $message->setChat(null);
            }
        }

        return $this;
    }
}
