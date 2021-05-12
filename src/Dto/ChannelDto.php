<?php

namespace App\Dto;

use App\Entity\Stream\Channel;
use App\Entity\User\Account;
use App\Entity\User\Settings;
use App\Service\User\Dto\Dto;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;

final class ChannelDto extends Dto
{
    public function __construct(
        /**
         * @Groups({ ChannelDto::GROUP_DEFAULT, ChannelDto::GROUP_LIST, ChannelDto::GROUP_CREATE, ChannelDto::GROUP_UPDATE })
         * @Assert\NotBlank(groups={ ChannelDto::GROUP_CREATE, ChannelDto::GROUP_UPDATE  })
         */
        private string $name,
        /**
         * @Groups({ ChannelDto::GROUP_DEFAULT, ChannelDto::GROUP_LIST, ChannelDto::GROUP_CREATE, ChannelDto::GROUP_UPDATE })
         * @Assert\Type(type="boolean", groups={ ChannelDto::GROUP_CREATE, ChannelDto::GROUP_UPDATE  })
         */
        private bool $default,
        /**
         * @Groups({ ChannelDto::GROUP_DEFAULT, ChannelDto::GROUP_LIST, ChannelDto::GROUP_CREATE, ChannelDto::GROUP_UPDATE })
         * @Assert\NotBlank(groups={ ChannelDto::GROUP_CREATE, ChannelDto::GROUP_UPDATE  })
         */
        private string $description,
        /**
         * @Groups({ ChannelDto::GROUP_DEFAULT, ChannelDto::GROUP_LIST })
         */
        private ?int $id = null,
        /**
         * @Groups({ ChannelDto::GROUP_DEFAULT, ChannelDto::GROUP_UPDATE, ChannelDto::GROUP_CREATE })
         */
        private ?SettingsDto $settings = null,
        private ?Account $account = null,
    ) {}

    public static function createFromObject(Channel $channel): self
    {
        return new ChannelDto(
            $channel->getName(),
            $channel->isDefault(),
            $channel->getDescription(),
            $channel->getId(),
            SettingsDto::createFromObject($channel->getSettings()),
        );
    }

    public static function createDto(
        string $name,
        bool $isDefault,
        string $description,
        Account $account,
        Settings $settings,
        int $id,
    ) {

    }

    /**
     * @return int|null
     */
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
     * @return bool
     */
    public function isDefault(): bool
    {
        return $this->default;
    }

    /**
     * @return string
     */
    public function getDescription(): string
    {
        return $this->description;
    }

    /**
     * @return null|Account
     */
    public function getAccount(): ?Account
    {
        return $this->account;
    }

    /**
     * @return null|SettingsDto
     */
    public function getSettings(): ?SettingsDto
    {
        return $this->settings;
    }
}
