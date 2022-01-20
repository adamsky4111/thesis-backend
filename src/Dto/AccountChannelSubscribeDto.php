<?php

namespace App\Dto;

use App\Entity\User\AccountChannelSubscribe;
use App\Service\User\Dto\Dto;
use Symfony\Component\Serializer\Annotation\Groups;

final class AccountChannelSubscribeDto extends Dto
{
    public function __construct(
        /**
         * @Groups({ AccountChannelSubscribeDto::GROUP_LIST })
         */
        private ?int $id = null,
        /**
         * @Groups({ AccountChannelSubscribeDto::GROUP_LIST })
         */
        private \DateTimeInterface $createdAt,
        /**
         * @Groups({ AccountChannelSubscribeDto::GROUP_LIST })
         */
        private ?ChannelDto $channel = null,
    ) {}

    public static function createFromObject(AccountChannelSubscribe $subscribe): self
    {
        $channel = $subscribe->getChannel();

        return new self(
            $subscribe->getId(),
            $subscribe->getCreatedAt(),
            ChannelDto::createFromObject($channel),
        );
    }

    /**
     * @return int|null
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return \DateTimeInterface
     */
    public function getCreatedAt(): \DateTimeInterface
    {
        return $this->createdAt;
    }

    /**
     * @return ChannelDto|null
     */
    public function getChannel(): ?ChannelDto
    {
        return $this->channel;
    }
}
