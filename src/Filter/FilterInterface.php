<?php

namespace App\Filter;


interface FilterInterface
{
    const TYPE_FROM_TO = 0;
    const TYPE_PHRASE = 1;
    const TYPE_BOOLEAN = 2;
    public function calculateOffset(): int;
    public function getLike(string $phrase): string;
    public function isAllowedField(string $field): bool;
    public function isAllowedSort(string $sort): bool;
    public function getTypeMapper(): array;
    public function isPaginated(): bool;
    public function getPage(): int;
}

