<?php

namespace App\Utils\Test;

use App\Dto\SettingsDto;
use JetBrains\PhpStorm\Pure;

class SettingTestHelper
{
    #[Pure] public static function createValidDto(): array
    {
        $name = 'stream1';
        $ageAllowed = 18;
        $defualt = true;
        $dto = new SettingsDto(null, $name, $defualt, $ageAllowed);
        return [$dto, [$name, $ageAllowed]];
    }
}