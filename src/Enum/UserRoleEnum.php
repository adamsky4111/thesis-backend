<?php

namespace App\Enum;


abstract class UserRoleEnum
{
    const ROLE_USER = 'ROLE_USER';

    static function getRolesArray(): array
    {
        return [self::ROLE_USER];
    }
}
