<?php

namespace App\Dto;

use App\Entity\Stream\StreamSchedule;
use App\Service\User\Dto\Dto;
use Symfony\Component\Serializer\Annotation\Groups;

final class StreamScheduleDto extends Dto
{
    public function __construct(
        /**
         * @Groups({ StreamScheduleDto::GROUP_LIST })
         */
        private ?int $id = null,
        /**
         * @Groups({ StreamScheduleDto::GROUP_LIST})
         */
        private ?\DateTimeInterface $createdAt = null,
        /**
         * @Groups({ StreamScheduleDto::GROUP_LIST})
         */
        private ?StreamDto $stream = null,
    ) {}

    public static function createFromObject(StreamSchedule $schedule): self
    {
        return new StreamScheduleDto(
            $schedule->getId(),
            $schedule->getCreatedAt(),
            StreamDto::createFromObject($schedule->getStream()),
        );
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->createdAt;
    }

    public function getStream(): ?StreamDto
    {
        return $this->stream;
    }
}
