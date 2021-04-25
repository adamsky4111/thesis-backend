<?php

namespace App\Repository\User;

use App\Entity\User\Settings;
use App\Service\Stream\Filter\FilterInterface;
use JetBrains\PhpStorm\ArrayShape;

interface SettingsRepositoryInterface
{
    public function find(int $id);
    #[ArrayShape([
        'items' => "array",
        'total' => "int",
        'pages' => "int"
    ])]
    public function findByFilter(FilterInterface $filter): array;
    public function save(Settings $settings): Settings;
    public function remove(Settings $settings): Settings;
}
