<?php

namespace App\Service\User\Model;

use App\Service\User\Dto\UserDto;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;


/**
 * Class ConfirmationAccountModel
 * @package App\Service\User\Model
 *
 * Class can be used to every confirmation based on email and token
 */
final class ConfirmationAccountModel
{
    /**
     * @Groups({ UserDto::GROUP_FORGOT_PASSWORD })
     * @Assert\NotBlank(groups={ UserDto::GROUP_TOKEN_CONFIRMATION })
     */
    private string $email;
    /**
     * @Groups({ UserDto::GROUP_CREATE, UserDto::GROUP_FORGOT_PASSWORD })
     * @Assert\NotBlank(groups={ UserDto::GROUP_TOKEN_CONFIRMATION })
     */
    private string $token;

    /**
     * @return string
     */
    public function getEmail(): string
    {
        return $this->email;
    }

    /**
     * @param string $email
     */
    public function setEmail(string $email): void
    {
        $this->email = $email;
    }

    /**
     * @return string
     */
    public function getToken(): string
    {
        return $this->token;
    }

    /**
     * @param string $token
     */
    public function setToken(string $token): void
    {
        $this->token = $token;
    }
}
