<?php

namespace App\Dto;

use App\Entity\Stream\Message;
use App\Service\User\Dto\Dto;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;

final class MessageDto extends Dto
{
    /**
     * @Groups({ MessageDto::GROUP_DEFAULT, MessageDto::GROUP_LIST })
     */
    private ?string $avatar;

    public function __construct(
        /**
         * @Groups({ MessageDto::GROUP_DEFAULT, MessageDto::GROUP_LIST, MessageDto::GROUP_CREATE })
         * @Assert\NotBlank(groups={ MessageDto::GROUP_CREATE, MessageDto::GROUP_UPDATE  })
         */
        private string $text,
        /**
         * @Groups({ MessageDto::GROUP_DEFAULT, MessageDto::GROUP_LIST, MessageDto::GROUP_CREATE })
         * @Assert\Type(type="boolean", groups={ MessageDto::GROUP_CREATE, MessageDto::GROUP_UPDATE  })
         */
        private ?int $chatId = null,
        /**
         * @Groups({ MessageDto::GROUP_DEFAULT, MessageDto::GROUP_LIST })
         */
        private ?string $nick = null,
        /**
        /**
         * @Groups({ MessageDto::GROUP_DEFAULT, MessageDto::GROUP_LIST })
         */
        private ?int $id = null,
        /**
         * @Groups({ MessageDto::GROUP_DEFAULT, MessageDto::GROUP_LIST })
         */
        private ?string $username = null,
    ) {}

    public static function createFromObject(Message $message): self
    {
        $avatar = $message
            ->getUser()
            ?->getAccount()
            ?->getAvatar()
            ?->getFilename();

        $dto = new MessageDto(
            $message->getContent(),
            $message->getChat()->getId(),
            $message->getUser()->getAccount()->getAccountInformation()->getNick(),
            $message->getId(),
            $message->getUser()->getUsername(),
        );

        $dto->setAvatar($avatar);

        return $dto;
    }

    /**
     * @return string
     */
    public function getText(): string
    {
        return $this->text;
    }

    /**
     * @return int
     */
    public function getChatId(): int
    {
        return $this->chatId;
    }

    /**
     * @return string|null
     */
    public function getNick(): ?string
    {
        return $this->nick;
    }

    /**
     * @return int|null
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return string|null
     */
    public function getUsername(): ?string
    {
        return $this->username;
    }

    /**
     * @return string|null
     */
    public function getAvatar(): ?string
    {
        return $this->avatar;
    }

    /**
     * @param string|null $avatar
     */
    public function setAvatar(?string $avatar): void
    {
        $this->avatar = $avatar;
    }
}
