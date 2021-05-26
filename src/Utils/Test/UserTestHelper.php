<?php

namespace App\Utils\Test;

use App\Enum\AccountRoleEnum;
use App\Enum\UserRoleEnum;
use App\Service\User\Dto\UserDto;
use JetBrains\PhpStorm\Pure;

class UserTestHelper
{
    #[Pure] public static function createValidUserDto(
        $username = null,
        $email = null,
        $password = null,
        $firstName = null,
        $lastName = null,
        $nick = null,
        $country = null,
        $about = null): array
    {
        $username = $username ?? 'userName';
        $email = $email ?? 'email@gmail.com';
        $password = $password ?? 'password';
        $firstName = $firstName ?? 'Jan';
        $lastName = $lastName ?? 'Nowak';
        $nick = $nick ?? 'pseudonim';
        $country = $country ?? 'Polska';
        $about = $about ?? 'about';

        $dto = new UserDto(
            $username,
            $email,
            $password,
            $firstName,
            $lastName,
            $nick,
            $country,
            $about
        );
        return [$dto, [$username, $email, $password, $firstName, $lastName, $nick, $country,$about]];
    }

    #[Pure] public static function createFromArray(array $array): array
    {
        [$username, $email, $password, $firstName, $lastName, $nick, $country, $about] = $array;
        $dto = new UserDto(
            $username,
            $email,
            $password,
            $firstName,
            $lastName,
            $nick,
            $country,
            $about
        );
        return [$dto, [$username, $email, $password, $firstName, $lastName, $nick, $country,$about]];
    }

    public static array $credentials = [
        UserRoleEnum::ROLE_USER => [
            AccountRoleEnum::REGULAR_ACCOUNT => [
                'email' => 'email@gmail.com',
                'password' => 'password',
                'username' => 'username',
            ],

            AccountRoleEnum::STREAM_ACCOUNT => [
                'email' => 'emailstream@gmail.com',
                'password' => 'password',
                'username' => 'testowy',
            ]
        ],
    ];
}