<?php

namespace App\Service\Stream\Manager;

use App\Dto\SettingsDto;
use App\Entity\User\Settings;
use App\Service\Stream\Filter\SettingsFilter;

interface SettingsManagerInterface
{
    public function getSettingsData(SettingsFilter $filter): iterable;
    public function get(int $id): SettingsDto;
    public function getOr404(int $id): Settings;
    public function delete(Settings $settings): SettingsDto;
    public function create(SettingsDto $dto): SettingsDto;
    public function update(SettingsDto $dto, Settings $settings): SettingsDto;
}
