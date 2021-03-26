<?php

namespace App\Dto;

use App\Entity\Stream\Stream;
use App\Service\User\Dto\Dto;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;

final class StreamDto extends Dto
{
    public function __construct(
        /**
         * @Groups({ UserDto::GROUP_DEFAULT, UserDto::GROUP_CREATE, UserDto::GROUP_UPDATE })
         * @Assert\NotBlank(groups={ UserDto::GROUP_CREATE, UserDto::GROUP_UPDATE  })
         */
        private string $name,
        /**
         * @Groups({ UserDto::GROUP_DEFAULT, UserDto::GROUP_CREATE, UserDto::GROUP_UPDATE })
         * @Assert\NotBlank(groups={ UserDto::GROUP_CREATE, UserDto::GROUP_UPDATE  })
         */
        protected bool $isDefault,
        /**
         * @Groups({ UserDto::GROUP_DEFAULT, UserDto::GROUP_CREATE, UserDto::GROUP_UPDATE })
         * @Assert\NotBlank(groups={ UserDto::GROUP_CREATE, UserDto::GROUP_UPDATE  })
         */
        private string $ageAllowed,
        /**
         * @Groups({ UserDto::GROUP_DEFAULT, UserDto::GROUP_CREATE, UserDto::GROUP_UPDATE })
         * @Assert\NotBlank(groups={ UserDto::GROUP_CREATE, UserDto::GROUP_UPDATE  })
         */
        private string $description,
        /**
         * @Groups({ UserDto::GROUP_DEFAULT, UserDto::GROUP_CREATE, UserDto::GROUP_UPDATE })
         * @Assert\NotBlank(groups={ UserDto::GROUP_CREATE })
         */
        private bool $startNow,
        /**
         * @Groups({ UserDto::GROUP_DEFAULT, UserDto::GROUP_CREATE, UserDto::GROUP_UPDATE })
         * @Assert\NotBlank(groups={ UserDto::GROUP_CREATE })
         */
        private \DateTimeInterface $startingAt,
        /**
         * @Groups({ UserDto::GROUP_DEFAULT, UserDto::GROUP_CREATE, UserDto::GROUP_UPDATE })
         * @Assert\NotBlank(groups={ UserDto::GROUP_CREATE })
         */
        private \DateTimeInterface $endingAt,
    ) {}

    public static function createFromObject(Stream $stream): self
    {
        $settings = $stream->getSettings();

        return new StreamDto(
            $stream->getName(),
            $settings->getIsDefault(),
            $settings->getAgeAllowed(),
            $stream->getDescription(),
            $stream->getIsActive(),
            $stream->getStartingAt(),
            $stream->getEndingAt(),
        );
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @return bool
     */
    public function isDefault(): bool
    {
        return $this->isDefault;
    }

    /**
     * @return string
     */
    public function getAgeAllowed(): string
    {
        return $this->ageAllowed;
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
}
