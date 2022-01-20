<?php

namespace App\Dto;

use App\Entity\User\Media;
use App\Service\User\Dto\Dto;
use Symfony\Component\Serializer\Annotation\Groups;

final class MediaDto extends Dto
{
    public function __construct(
        /**
         * @Groups({ MediaDto::GROUP_DEFAULT, MediaDto::GROUP_LIST })
         */
        private ?int $id,
        /**
         * @Groups({ MediaDto::GROUP_DEFAULT, MediaDto::GROUP_LIST })
         */
        private string $filename,
        /**
         * @Groups({ MediaDto::GROUP_DEFAULT, MediaDto::GROUP_LIST })
         */
        private string $path,
        /**
         * @Groups({ MediaDto::GROUP_DEFAULT, MediaDto::GROUP_LIST })
         */
        private ?int $size,
    ) {}

    public static function createFromObject(Media $media, string $path): self
    {
        return new self(
            $media->getId(),
            $media->getOriginalFilename(),
            $path,
            $media->getSize(),
        );
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getFilename(): string
    {
        return $this->filename;
    }

    public function getPath(): string
    {
        return $this->path;
    }

    public function getSize(): ?int
    {
        return $this->size;
    }
}
