<?php

namespace App\Enum;


abstract class AccountRoleEnum
{
    const REGULAR_ACCOUNT = 'regular';
    const STREAM_ACCOUNT = 'stream';

    static function getRolesArray(): array
    {
        return [self::REGULAR_ACCOUNT, self:: STREAM_ACCOUNT];
    }
}
