<?php

namespace App\Utils\Test;

use App\Dto\ChannelDto;

class ChannelTestHelper
{
    public static function createValidDto(): array
    {
        $name = 'stream1';
        $default = true;
        $description = 'desc';
        [$setting,] = SettingTestHelper::createValidDto();
        $dto = new ChannelDto($name, $default, $description, null, $setting);
        return [$dto, [$name, $default, $description]];
    }
}