<?php

namespace App\Service\User\Dto;

use App\Entity\User\User;
use JetBrains\PhpStorm\Pure;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;

final class UserDto extends Dto
{
    public const GROUP_FORGOT_PASSWORD = 'forgot_password';

    public function __construct(
        # user data
        /**
         * @Groups({ UserDto::GROUP_DEFAULT, UserDto::GROUP_CREATE, UserDto::GROUP_FORGOT_PASSWORD })
         * @Assert\NotBlank(groups={ UserDto::GROUP_CREATE })
         */
        private string $username,
        /**
         * @Groups({ UserDto::GROUP_DEFAULT, UserDto::GROUP_CREATE, UserDto::GROUP_FORGOT_PASSWORD })
         * @Assert\NotBlank(groups={ UserDto::GROUP_CREATE })
         */
        private string $email,
        /**
         * @Groups({ UserDto::GROUP_DEFAULT, UserDto::GROUP_CREATE, UserDto::GROUP_FORGOT_PASSWORD })
         * @Assert\NotBlank(groups={ UserDto::GROUP_CREATE })
         */
        private string $plainPassword,
        # account information data
        /**
         * @Groups({ UserDto::GROUP_DEFAULT, UserDto::GROUP_CREATE, UserDto::GROUP_UPDATE })
         */
        private ?string $firstName,
        /**
         * @Groups({ UserDto::GROUP_DEFAULT, UserDto::GROUP_CREATE, UserDto::GROUP_UPDATE })
         */
        private ?string $lastName,
        /**
         * @Groups({ UserDto::GROUP_DEFAULT, UserDto::GROUP_CREATE, UserDto::GROUP_UPDATE })
         */
        private ?string $nick,
        /**
         * @Groups({ UserDto::GROUP_DEFAULT, UserDto::GROUP_CREATE, UserDto::GROUP_UPDATE })
         */
        private ?string $country,
        /**
         * @Groups({ UserDto::GROUP_DEFAULT, UserDto::GROUP_CREATE, UserDto::GROUP_UPDATE })
         */
        private ?string $about,
    ) { }

    #[Pure] public static function createFromUser(User $user): self
    {
        $info = $user->getAccount()->getAccountInformation();

        return new UserDto(
            $user->getUsername(),
            $user->getEmail(),
            $user->getPlainPassword(),
            $info->getFirstName(),
            $info->getLastName(),
            $info->getNick(),
            $info->getCountry(),
            $info->getAbout(),
        );
    }

    /**
     * @return string
     */
    public function getUsername(): string
    {
        return $this->username;
    }

    /**
     * @return string
     */
    public function getEmail(): string
    {
        return $this->email;
    }

    /**
     * @return string
     */
    public function getPlainPassword(): string
    {
        return $this->plainPassword;
    }

    /**
     * @return string|null
     */
    public function getFirstName(): ?string
    {
        return $this->firstName;
    }

    /**
     * @return string|null
     */
    public function getLastName(): ?string
    {
        return $this->lastName;
    }

    /**
     * @return string|null
     */
    public function getNick(): ?string
    {
        return $this->nick;
    }

    /**
     * @return string|null
     */
    public function getCountry(): ?string
    {
        return $this->country;
    }

    /**
     * @return string|null
     */
    public function getAbout(): ?string
    {
        return $this->about;
    }
}
