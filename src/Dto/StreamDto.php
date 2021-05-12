<?php

namespace App\Dto;

use App\Entity\Stream\Channel;
use App\Entity\Stream\Stream;
use App\Service\User\Dto\Dto;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;

final class StreamDto extends Dto
{
    public function __construct(
        /**
         * @Groups({ StreamDto::GROUP_DEFAULT, StreamDto::GROUP_LIST, StreamDto::GROUP_SHOW })
         */
        private ?int $id = null,
        /**
         * @Groups({ StreamDto::GROUP_DEFAULT, StreamDto::GROUP_LIST, StreamDto::GROUP_CREATE, StreamDto::GROUP_UPDATE, StreamDto::GROUP_SHOW })
         * @Assert\NotBlank(groups={ StreamDto::GROUP_CREATE, StreamDto::GROUP_UPDATE  })
         */
        private string $name,
        /**
         * @Groups({ StreamDto::GROUP_DEFAULT, StreamDto::GROUP_LIST, StreamDto::GROUP_CREATE, StreamDto::GROUP_UPDATE, StreamDto::GROUP_SHOW })
         * @Assert\NotBlank(groups={ StreamDto::GROUP_CREATE, StreamDto::GROUP_UPDATE  })
         */
        private string $description,
        /**
         * @Groups({ StreamDto::GROUP_DEFAULT, StreamDto::GROUP_CREATE, StreamDto::GROUP_UPDATE, StreamDto::GROUP_SHOW })
         * @Assert\Type(type="boolean", groups={ StreamDto::GROUP_CREATE })
         */
        private bool $startNow,
        /**
         * @Groups({ StreamDto::GROUP_DEFAULT, StreamDto::GROUP_LIST, StreamDto::GROUP_CREATE, StreamDto::GROUP_UPDATE, StreamDto::GROUP_SHOW })
         * @Assert\NotBlank(groups={ StreamDto::GROUP_CREATE })
         */
        private ?\DateTimeInterface $startingAt,
        /**
         * @Groups({ StreamDto::GROUP_DEFAULT, StreamDto::GROUP_CREATE, StreamDto::GROUP_UPDATE, StreamDto::GROUP_SHOW })
         * @Assert\NotBlank(groups={ StreamDto::GROUP_CREATE })
         */
        private \DateTimeInterface $endingAt,
        /**
         * @Groups({ StreamDto::GROUP_DEFAULT, StreamDto::GROUP_CREATE, StreamDto::GROUP_UPDATE, StreamDto::GROUP_SHOW })
         */
        private ?SettingsDto $settings = null,
        /**
         * @Groups({ StreamDto::GROUP_DEFAULT, StreamDto::GROUP_CREATE, StreamDto::GROUP_UPDATE, StreamDto::GROUP_SHOW })
         */
        private ?ChannelDto $channel = null,
    ) {}

    public static function createFromObject(Stream $stream): self
    {
        $settings = $stream->getSettings();
        $channel = $stream->getChannel();

        return new StreamDto(
            $stream->getId(),
            $stream->getName(),
            $stream->getDescription(),
            $stream->getIsActive(),
            $stream->getStartingAt(),
            $stream->getEndingAt(),
            SettingsDto::createFromObject($settings),
            ChannelDto::createFromObject($channel),
        );
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @return string
     */
    public function getDescription(): string
    {
        return $this->description;
    }

    /**
     * @return bool
     */
    public function isStartNow(): bool
    {
        return $this->startNow;
    }

    /**
     * @return \DateTimeInterface
     */
    public function getStartingAt(): \DateTimeInterface
    {
        return $this->startingAt;
    }

    /**
     * @return \DateTimeInterface
     */
    public function getEndingAt(): \DateTimeInterface
    {
        return $this->endingAt;
    }

    public function getSettings(): ?SettingsDto
    {
        return $this->settings;
    }

    public function getChannel(): ?ChannelDto
    {
        return $this->channel;
    }
}
