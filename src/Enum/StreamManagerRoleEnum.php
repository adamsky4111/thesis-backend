<?php

namespace App\Enum;


abstract class StreamManagerRoleEnum
{
    const REMOVE_WATCHER = 'rm_user';
    const BAN_WATCHER = 'ban_user';
    const DELETE_MESSAGE = 'message_delete';
    const STOP_STREAM = 'stop_stream';
    const REMOVE_MANAGER = 'remove_manager';
    const ADD_MANAGER = 'add_manager';
    // no more than himself
    const ADD_RULE_TO_MANAGER = 'add_rule';

    static function getRolesArray(): array
    {
        return [
            self::REMOVE_WATCHER,
            self::BAN_WATCHER,
            self::DELETE_MESSAGE,
            self::STOP_STREAM,
            self::REMOVE_MANAGER,
            self::ADD_MANAGER,
            self::ADD_RULE_TO_MANAGER,
        ];
    }
}
