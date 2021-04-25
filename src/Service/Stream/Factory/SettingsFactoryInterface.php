<?php

namespace App\Service\Stream\Factory;

use App\Dto\SettingsDto;
use App\Entity\User\Account;
use App\Entity\User\Settings;

interface SettingsFactoryInterface
{
    public function create(SettingsDto $dto, Account $account): Settings;
    public function update(SettingsDto $dto, Settings $settings): Settings;
}
