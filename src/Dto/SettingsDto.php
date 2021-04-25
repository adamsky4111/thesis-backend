<?php

namespace App\Dto;

use App\Entity\User\Settings;
use App\Service\User\Dto\Dto;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;

final class SettingsDto extends Dto
{
    public function __construct(
        /**
         * @Groups({ SettingsDto::GROUP_DEFAULT })
         */
        private ?int $id = null,
        /**
         * @Groups({ SettingsDto::GROUP_DEFAULT, SettingsDto::GROUP_CREATE, SettingsDto::GROUP_UPDATE })
         * @Assert\NotBlank(groups={ SettingsDto::GROUP_CREATE, SettingsDto::GROUP_UPDATE  })
         */
        private string $name,
        /**
         * @Groups({ SettingsDto::GROUP_DEFAULT, SettingsDto::GROUP_CREATE, SettingsDto::GROUP_UPDATE })
         * @Assert\Type(type="boolean", groups={ SettingsDto::GROUP_CREATE, SettingsDto::GROUP_UPDATE  })
         */
        private bool $isDefault,
        /**
         * @Groups({ SettingsDto::GROUP_DEFAULT, SettingsDto::GROUP_CREATE, SettingsDto::GROUP_UPDATE })
         * @Assert\NotBlank(groups={ SettingsDto::GROUP_CREATE, SettingsDto::GROUP_UPDATE  })
         */
        private int $ageAllowed,
    ) {}

    public static function createFromObject(Settings $settings): self
    {
        return new SettingsDto(
            $settings->getId(),
            $settings->getName(),
            $settings->getIsDefault(),
            $settings->getAgeAllowed(),
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
     * @param string $name
     */
    public function setName(string $name): void
    {
        $this->name = $name;
    }

    /**
     * @return bool
     */
    public function isDefault(): bool
    {
        return $this->isDefault;
    }

    /**
     * @param bool $isDefault
     */
    public function setIsDefault(bool $isDefault): void
    {
        $this->isDefault = $isDefault;
    }

    /**
     * @return int
     */
    public function getAgeAllowed(): int
    {
        return $this->ageAllowed;
    }

    /**
     * @param int $ageAllowed
     */
    public function setAgeAllowed(int $ageAllowed): void
    {
        $this->ageAllowed = $ageAllowed;
    }
}
